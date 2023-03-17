<?php
class Article
{
    // Thuộc tính

    private $article_id;
    private $title;
    private $song_name;
    private $cat_name;
    private $summary;
    private $content;
    private $author_name;
    private $date;
    private $image;

    public function __construct($article_id ,$title,$song_name,$cat_name, $summary,$content,$author_name,$date,$image)
    {
        $this->article_id = $article_id;
        $this->title = $title;
        $this->song_name = $song_name;
        $this->cat_name = $cat_name;
        $this->summary = $summary;
        $this->content = $content;
        $this->author_name = $author_name;
        $this->date = $date;
        $this->image = $image;
    }

    // Setter và Getter

    public function getArticle_id()
    {

        return $this->article_id;

    }

    public function getTitle()
    {

        return $this->title;

    }

    public function setTitle($title)
    {

        $this->title=$title;

    }




    public function getSong_name()
    {

        return $this->song_name;

    }

    public function setSong_name($song_name)
    {

        $this->song_name=$song_name;

    }

    public function getCat_name()
    {

        return $this->cat_name;

    }

    public function setCat_name($cat_name)
    {

        $this->cat_name=$cat_name;

    }

    public function getSummary()
    {

        return $this->summary;

    }

    public function setSummary($summary)
    {

        $this->summary=$summary;

    }

    public function getContent()
    {

        return $this->content;

    }

    public function setContent($content)
    {

        $this->content=$content;

    }

    public function getAuthor_name()
    {

        return $this->author_name;

    }

    public function setAuthor_name($author_name)
    {

        $this->author_name=$author_name;

    }




    public function getDate()
    {

        return $this->date;

    }

    public function setDate($date)
    {

        $this->date=$date;

    }




    public function getImage()
    {

        return $this->image;

    }

    public function setImage($image)
    {

        $this->image=$image;

    }
}
