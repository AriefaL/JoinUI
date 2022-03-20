<?php declare(strict_types = 1);

namespace library\formapi;

class SimpleForm extends Form {

    const IMAGE_TYPE_PATH = 0;
    const IMAGE_TYPE_URL = 1;

    /** @var string */
    private $content = "";

    private $labelMap = [];

    /**
     * @param callable|null $callable
     */
    public function __construct(?callable $callable) {
        parent::__construct($callable);
        $this->data["type"] = "form";
        $this->data["title"] = "";
        $this->data["content"] = $this->content;
    }

    public function processData(&$data) : void {
        $data = $this->labelMap[$data] ?? null;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title) : void {
        $this->data["title"] = $title;
        $this->labelMap[] = 0;
    }

    /**
     * @return string
     */
    public function getTitle() : string {
        return $this->data["title"];
    }

    /**
     * @return string
     */
    public function getContent() : string {
        return $this->data["content"];
    }

    /**
     * @param string $content
     */
    public function setContent(string $content) : void {
        $this->data["content"] = $content;        
    }

    /**
     * @param bool           $value
     * @param string         $text
     * @param int               $imageType
     * @param string         $imagePath
     * @param string|null $label
     */
    public function addButton(bool $value = true, string $text = "Sus", int $imageType = -1, string $imagePath = "", ?string $label = null) : void {
        $content = ["text" => $text];
        if($value){
            if($imageType !== -1) {
                $content["image"]["type"] = $imageType === 0 ? "path" : "url";
                $content["image"]["data"] = $imagePath;
            }
            $this->data["buttons"][] = $content;
            $this->labelMap[] = $label ?? count($this->labelMap);
        } else {
            $this->data["buttons"] = [];
        }
    }

}
