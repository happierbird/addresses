<?php
namespace CoolBlue\Response;


class Response
{
    protected $data = null;
    protected $format = null;
    protected $code = null;
    protected $content = null;
    protected $content_type = null;
    protected $headers = null;

    public function __construct(array $data, $code = 200, $format = null, $content_type = null, $headers = null)
    {
        $this->data = $data;
        $this->code = $code;
        $this->format = $format;
        $this->content_type = $content_type;
        $this->headers = $headers;
    }

    /**
     * @param array|null $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param null|string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return null|string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param null $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param int|null $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return int|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param null $content_type
     */
    public function setContentType($content_type)
    {
        $this->content_type = $content_type;
    }

    /**
     * @return null
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
     * @param null $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return null
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    public function output()
    {
        if (!empty($this->code)) {
            http_response_code($this->code);
        }

        if (!empty($this->content_type)) {
            header('Content-Type: ' . $this->content_type);
        }

        echo $this->content;
    }
}