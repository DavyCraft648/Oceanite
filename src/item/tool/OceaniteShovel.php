<?php
declare(strict_types=1);

namespace DavyCraft648\Oceanite\item\tool;

use customiesdevs\customies\item\component\HandEquippedComponent;
use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ToolTier;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;

class OceaniteShovel extends \pocketmine\item\Shovel implements \customiesdevs\customies\item\ItemComponents{
	use ItemComponentsTrait {
		getComponents as _getComponents;
	}

	public function __construct(ItemIdentifier $identifier, string $name){
		parent::__construct($identifier, $name, ToolTier::DIAMOND());
		$this->initComponent("oceanite_shovel", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT, CreativeInventoryInfo::GROUP_SHOVEL));
		$this->addComponent(new HandEquippedComponent(true));
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
				"minecraft:concretePowder",
				"minecraft:mycelium",
				"minecraft:podzol",
				"minecraft:snow",
				"minecraft:clay"
			] as $block){
			$destroy_speeds->push(CompoundTag::create()
				->setString("block", $block)
				->setInt("speed", 12)
			);
		}
		$destroy_speeds->push(CompoundTag::create()
			->setTag("block", CompoundTag::create()
				->setString("tags", "q.any_tag('dirt', 'sand', 'gravel', 'grass', 'snow', 'dirt')")
			)
			->setInt("speed", 12)
		);
		return $itemData->setTag("components", $itemData->getCompoundTag("components")
			->setTag("minecraft:digger", $digger->setTag("destroy_speeds", $destroy_speeds))
		);
	}
}
