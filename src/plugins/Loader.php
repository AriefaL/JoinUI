<?php declare(strict_types = 1);
namespace plugins;

use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {
	
	/** @var int $version */
	private int $version = 1;
	/** @var string $config */
	private string $config = "Settings.yml";
	
	protected function onLoad(): void {
		$this->saveResource($this->config);
	}
	
	protected function onEnable(): void {
		if ($this->getVersionSettings() !== $this->version) {
            $this->getLogger()->error("Invalid version config! Default version is \"".$this->version."\"");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }
		
		$this->getServer()->getPluginManager()->registerEvents(new Listeners($this), $this);
	}
	
	/**
	 * @return array
     */
	public function getSettings(): array {
        return $this->getConfig()->getAll();
    }
    
    /**
     * @return integer
     */
    public function getVersionSettings(): int {
        return $this->getSettings()["Version"];
    }
    
    /**
     * @return boolean
     */
    public function getValueShowUI(): bool {
    	$value = $this->getSettings()["Show-UI"];
    	if (!in_array($value, [true, false])) {
            return false;
        }
    	return $value;
    }
    
    /**
     * @return Forms
     */
    public function getForm(): Forms {
    	return new Forms($this);
    }
}
