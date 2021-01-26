<?php
namespace App\Entity;

class RestaurantSearch {

    /**
     * @var string|null
     */
    private $tag;

    /**
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param string|null $tag
     * @return RestaurantSearch
     */
    public function setTag(string $tag): RestaurantSearch
    {
        $this->tag = $tag;
        return $this;
    }



}