<?

foreach ($this->params as $key)
{
    if ($key!==Block::MARKER_KEY)
    {
        render("/".$key);
    }
}

?>