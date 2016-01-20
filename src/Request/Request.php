<?php
namespace CoolBlue\Request;

class Request
{
    /**
     * @var string
     */
    public $path;

    /**
     * @var mixed
     */
    public $content = null;

    /**
     * @var array
     */
    public $post;

    /**
     * @var array
     */
    public $query;

    /**
     * @var string
     */
    public $method;


    public function __construct()
    {
        $this->path = $this->preparePath();
        $this->method = $this->prepareMethod();
        $this->query = $this->prepareQuery();
        $this->content = $this->getContent();
        $this->post = $this->getPost();
    }

    private function prepareQuery()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (FALSE !== ($pos = strpos($uri, '?'))) {
            $uri = substr($uri, $pos);
        }
        parse_str($uri, $data);

        return $data;
    }

    private function preparePath()
    {
        // remove GET params
        if (FALSE !== ($pos = strpos($_SERVER['REQUEST_URI'], '?'))) {
            return substr($_SERVER['REQUEST_URI'], 0, $pos);
        }

        return $_SERVER['REQUEST_URI'];
    }

    private function prepareMethod()
    {
        if (isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
            if (!in_array($method, array('PUT', 'DELETE'))) {
                $method = $_SERVER['REQUEST_METHOD'];
            }
        } else {
            $method = $_SERVER['REQUEST_METHOD'];
        }

        return $method;
    }

    public function getPost()
    {
        return $_POST;
    }

    public function getContent()
    {
        $currentContentIsResource = is_resource($this->content);
        if ($currentContentIsResource) {
            rewind($this->content);

            return stream_get_contents($this->content);
        }
        if (null === $this->content) {
            $this->content = file_get_contents('php://input');
        }

        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}