<?php
declare(strict_types=1);

namespace DavyCraft648\Oceanite\item\tool;

use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ToolTier;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;

class OceaniteHoe extends \pocketmine\item\Hoe implements \customiesdevs\customies\item\ItemComponents{
	use ItemComponentsTrait {
		getComponents as _getComponents;
	}

	public function __construct(ItemIdentifier $identifier, string $name){
		parent::__construct($identifier, $name, ToolTier::DIAMOND());
		$this->initComponent("oceanite_hoe", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT, CreativeInventoryInfo::GROUP_HOE));
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
				"minecraft:mangrove_leaves",
				"minecraft:moss_block",
				"minecraft:leaves",
				"minecraft:shroomlight",
				"minecraft:sponge",
				"minecraft:target",
				"minecraft:hay_block",
				"minecraft:leaves2",
				"minecraft:warped_wart_block",
				"minecraft:nether_wart_block",
				"minecraft:sculk",
				"minecraft:sculk_catalyst",
				"minecraft:sculk_shrieker",
				"minecraft:sculk_vein",
				"minecraft:sculk_sensor",
				"minecraft:dried_kelp_block"
			] as $block){
			$destroy_speeds->push(CompoundTag::create()
				->setString("block", $block)
				->setInt("speed", 12)
			);
		}
		return $itemData->setTag("components", $itemData->getCompoundTag("components")
			->setTag("minecraft:digger", $digger->setTag("destroy_speeds", $destroy_speeds))
		);
	}
}
