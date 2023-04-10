<?php
declare(strict_types=1);

namespace DavyCraft648\Oceanite\item\tool;

use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ToolTier;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;

class OceaniteSword extends \pocketmine\item\Sword implements \customiesdevs\customies\item\ItemComponents{
	use ItemComponentsTrait {
		getComponents as _getComponents;
	}

	public function __construct(ItemIdentifier $identifier, string $name){
		parent::__construct($identifier, $name, ToolTier::DIAMOND());
		$this->initComponent("oceanite_sword", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT, CreativeInventoryInfo::GROUP_SWORD));
	}

	public function getMaxDurability() : int{
		return 2031;
	}

	protected function getBaseMiningEfficiency() : float{
		return 12;
	}

	public function getComponents() : CompoundTag{
		$itemData = $this->_getComponents();
		$digger = CompoundTag::create()
			->setByte("use_efficiency", 1);
		$destroy_speeds = new ListTag();
		foreach(
			[
				"minecraft:web",
				"minecraft:bamboo",
				"minecraft:melon_block",
				"minecraft:pumpkin",
				"minecraft:cocoa",
				"minecraft:lit_pumpkin",
				"minecraft:leaves",
				"minecraft:vine",
				"minecraft:hay_block"
			] as $block){
			$destroy_speeds->push(CompoundTag::create()
				->setString("block", $block)
				->setInt("speed", match($block){
					"minecraft:web" => 15,
					"minecraft:bamboo" => 35,
					default => 1
				})
			);
		}
		return $itemData->setTag("components", $itemData->getCompoundTag("components")
			->setTag("minecraft:digger", $digger->setTag("destroy_speeds", $destroy_speeds))
		);
	}
}
