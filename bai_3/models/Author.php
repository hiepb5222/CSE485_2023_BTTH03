<?php
class Author
{
    // Thuộc tính

    private $author_id;
    private $author_name;
    private $author_pic;


    public function __construct($author_id, $author_name,$author_pic)
    {
        $this->author_id = $author_id;
        $this->author_name = $author_name;
        $this->author_pic = $author_pic;
    }

    // Setter và Getter
    public function getAuthor_id()
    {
        return $this->author_id;
    }
    public function setAuthor_id($author_id)
    {
        $this->author_id = $author_id;
    }
    public function getAuthor_name()
    {
        return $this->author_name;
    }
    public function setAuthor_name($author_name)
    {
        $this->author_name = $author_name;
    }
    public function getAuthor_pic()
    {
        return $this->author_pic;
    }
    public function setAuthor_pic($author_pic)
    {
        $this->author_pic = $author_pic;
    }
}
