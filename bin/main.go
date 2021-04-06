package main

import (
	"errors"
	"fmt"
	"io/ioutil"
	"net/http"
	"strings"
	"time"
)

type Proxy struct {
	Body string
	Time time.Time
}

var proxies map[string]Proxy

func httpGet(url string) (string, error) {
	resp, err := http.Get(url)
	if err != nil {
		return "", err
	}

	defer resp.Body.Close()
	if resp.StatusCode != http.StatusOK {
		return "", errors.New("status not equal 200")
	}

	bodyBytes, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		return "", errors.New("unreadable bytes")
	}

	return string(bodyBytes), nil
}

func proxy(w http.ResponseWriter, req *http.Request) {
	u := strings.Replace(req.URL.Path, "internal", "api", 1)
	p, ok := proxies[u]
	if !ok || p.Time.Before(time.Now()) {
		resp, err := httpGet("https://fktpm.ru" + u)
		if err != nil {
			return
		}

		p = Proxy{Body: resp, Time: time.Now().Add(time.Hour)}
		proxies[u] = p
	}

	w.Header().Set("Content-Type", "application/json")
	_, _ = fmt.Fprint(w, p.Body)
}

func main() {
	proxies = make(map[string]Proxy)

	http.HandleFunc("/internal/v1/file/blocks", proxy)
	_ = http.ListenAndServe(":6631", nil)
}
