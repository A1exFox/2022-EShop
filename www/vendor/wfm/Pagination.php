<?php

namespace wfm;

class Pagination 
{
    public $currentPage;
    public $perpage;
    public $total;
    public $countPages;
    public $uri;

    public function __construct($page, $perpage, $total)
    {
        $this->perpage = $perpage;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($page);
        $this->uri = $this->getParams();
    }

    public function getHtml()
    {
        $back = null;
        $forward = null;
        $startpage = null;
        $endpage = null;
        $page2left = null;
        $page1left = null;
        $page2right = null;
        $page1right = null;

        if ($this->currentPage > 1)
            $back = "<li class=\"page-item\"><a class=\"page-link\" href=\"". $this->getLink($this->currentPage - 1) ."\">&lt;</a></li>";

        if ($this->currentPage < $this->countPages)
            $forward = "<li class=\"page-item\"><a class=\"page-link\" href=\"". $this->getLink($this->currentPage + 1) ."\">&gt;</a></li>";

        if ($this->currentPage > 3)
            $startpage = "<li class=\"page-item\"><a class=\"page-link\" href=\"". $this->getLink(1) ."\">&laquo;</a></li>";

        if ($this->currentPage < ($this->countPage - 2))
            $endpage = "<li class=\"page-item\"><a class=\"page-link\" href=\"". $this->getLink($this->countPages) ."\">&raquo;</a></li>";

        if ($this->currentPage - 2 > 0)
            $page2left = "<li class=\"page-item\"><a class=\"page-link\" href=\"". $this->getLink($this->currentPage - 2) ."\">". ($this->currentPage - 2) ."</a></li>";

        if ($this->currentPage - 1 > 0)
            $page1left = "<li class=\"page-item\"><a class=\"page-link\" href=\"". $this->getLink($this->currentPage - 1) ."\">". ($this->currentPage - 1) ."</a></li>";

        if ($this->currentPage + 2 <= $this->countPages)
            $page2right = "<li class=\"page-item\"><a class=\"page-link\" href=\"". $this->getLink($this->currentPage + 2) ."\">". ($this->currentPage + 2) ."</a></li>";

        if ($this->currentPage + 1 > $this->countPages)
            $page1right = "<li class=\"page-item\"><a class=\"page-link\" href=\"". $this->getLink($this->currentPage + 1) ."\">". ($this->currentPage + 1) ."</a></li>";

        $html = "
            <nav aria-label="Page navigation example">
                <ul class=\"pagination\">
                    $startpage
                    $back
                    $page2left
                    $page1left
                    <li class=\"page-item active\">
                        <a class=\"page-link\">
                            $this->currentPage;
                        </a>
                    </li>
                    $page1right
                    $page2right
                    $forward
                    $endpage
                </ul>
            </nav>
            ";
        return $html;
    }

    public function getLink($page)
    {
        if ($page == 1) 
            return rtrim($this->uri, '?&');

        if (str_contains($this->uri, '&')) {
            return "{$this->uri}page={$page}";
        } else {
            if (str_contains($this->uri, '?'))
                return "{$this->uri}page={$page}";
            else
                return "{$this->uri}?page={$page}";
            
        }
        
    }

    public function __toString()
    {
        return $this->getHtml();
    }

    public function getCountPages()
    {
        if (!$this->perpage)
            throw new \Exception("Items perpage has to be more then 0. Current value is 0",500);

        $count = ceil($this->total / $this->perpage);

        if (!$count)
            $count = 1;

        return $count;
    }

    public function getCurrentPage($page) 
    {
        if (!$page || $page < 1) 
            $page = 1;

        if ($page > $this->countPages)
            $page = $this->countPages;

        return $page;
    }

    public function getStart()
    {
        return ($this->currentPage - 1) * $this->perpage;
    }

    public function getParams()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode("?", $url);

        $uri = $url[0];

        if (isset($url[1]) && $url[1] != '') {
            $uri .= '?';
            $params = explode("&", $url[1]);

            foreach($params as $param) {
                if (!preg_match("#page=#", $param))
                    $uri .= "{$param}&";
            }
        }

        return $uri;
    }
}