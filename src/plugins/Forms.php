<?php declare(strict_types = 1);

use library\formapi;
use pocketmine\player\Player;

class Forms {

    public function __construct(private Loader $plugin) {
    	// NOPE
    }
    
    /**
     * @return Loader
     */
    private function getPlugin(): Loader {
    	return $this->plugin;
    }
    
    /**
     * @return array
     */
    public function getSettings(): array {
    	return $this->getPlugin()->getSettings()["Form"];
    }
    
    /**
     * @param Player $player
     */
    public function sendToPlayer(Player $player) {
    	return ;
    }
    
    /**
     * @param Player $player
     * @return SimpleForm
     */
    public function onCreateForm(Player $player): SimpleForm {
    	$form = new SimpleForm(function(Player $player, $data = null) {
            if ($data === null) return;
        });
        
        $form->setTitle($this->onReplace($player, (is_string($title = $this->getSettings()["Title"])) ? $title : "JoinUI");
        $form->setContent($this->onReplace($player, implode("\n", $this->getSettings()["Content"])));
        
        $valueButton = $this->getSettings()["Button-value"];
        $formatButton = $this->getSettings()["Button-format"];
        $array = [];
        if (isset($formatButton)) {
        	$array = $formatButton;
        }
        
        $textButton = "Text Button";
        if (isset($array[0])) {
        	$textButton = $this->onReplace($player, $array[0]);
        }
        
        $imageType = -1;
        if (isset($array[1])) {
        	$imageType = (int)$array[1];
        }
        
        $imagePath = "";
        if (isset($array[2])) {
        	$imagePath = (string)$array[2];
        }
        
        $form->addButton($valueButton, $textButton, $imageType, $imagePath, null);
        
        return $form;
    }

    /**
     * @param Player|null $player
     * @param string         $texter
     * @return string
     */
    private function onReplace(?Player $player, string $texter = ""): string {	
		$format_replace = [
			"{player_name}",
			"{ping}",
			"{online}",
			"{line}",
			"&"
		];
		$code_replace = [
			(($player === null) ? "-" : $player->getName()),
			(($player === null) ? "-" : $player->getNetworkSession()->getPing()),
			count($this->getPlugin()->getServer()->getOnlinePlayers()),
			"\n",
			"§"
		];
		
		return str_replace($format_replace, $code_replace, $texter);
	}
}