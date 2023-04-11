<?php
declare(strict_types=1);

namespace DavyCraft648\Oceanite\item\tool;

use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ToolTier;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;

class OceaniteAxe extends \pocketmine\item\Axe implements \customiesdevs\customies\item\ItemComponents{
	use ItemComponentsTrait {
		getComponents as _getComponents;
	}

	public function __construct(ItemIdentifier $identifier, string $name){
		parent::__construct($identifier, $name, ToolTier::DIAMOND());
		$this->initComponent("oceanite_axe", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT, CreativeInventoryInfo::GROUP_AXE));
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
				"minecraft:mangrove_fence_gate",
				"minecraft:mangrove_fence",
				"minecraft:mangrove_planks",
				"minecraft:mangrove_button",
				"minecraft:mangrove_double_slab",
				"minecraft:mangrove_slab",
				"minecraft:mangrove_door",
				"minecraft:carved_pumpkin",
				"minecraft:lit_pumpkin",
				"minecraft:warped_pressure_plate",
				"minecraft:crimson_pressure_plate",
				"minecraft:mangrove_pressure_plate",
				"minecraft:dark_oak_pressure_plate",
				"minecraft:acacia_pressure_plate",
				"minecraft:jungle_pressure_plate",
				"minecraft:birch_pressure_plate",
				"minecraft:spruce_pressure_plate",
				"minecraft:wooden_pressure_plate",
				"minecraft:warped_standing_sign",
				"minecraft:crimson_standing_sign",
				"minecraft:mangrove_standing_sign",
				"minecraft:darkoak_standing_sign",
				"minecraft:acacia_standing_sign",
				"minecraft:jungle_standing_sign",
				"minecraft:birch_standing_sign",
				"minecraft:spruce_standing_sign",
				"minecraft:standing_sign",
				"minecraft:smithing_table",
				"minecraft:fletching_table",
				"minecraft:stripped_mangrove_wood",
				"minecraft:mangrove_wood",
				"minecraft:wood",
				"minecraft:stripped_mangrove_log",
				"minecraft:mangrove_log",
				"minecraft:stripped_dark_oak_log",
				"minecraft:stripped_acacia_log",
				"minecraft:stripped_jungle_log",
				"minecraft:stripped_birch_log",
				"minecraft:stripped_spruce_log",
				"minecraft:stripped_oak_log",
				"minecraft:log",
				"minecraft:log2",
				"minecraft:chest",
				"minecraft:melon_block",
				"minecraft:crafting_table",
				"minecraft:crimson_planks",
				"minecraft:crimson_stem",
				"minecraft:stripped_crimson_stem",
				"minecraft:stripped_crimson_hyphae",
				"minecraft:crimson_hyphae",
				"minecraft:crimson_slab",
				"minecraft:crimson_pressure_plate",
				"minecraft:crimson_fence",
				"minecraft:crimson_trapdoor",
				"minecraft:crimson_fence_gate",
				"minecraft:oak_stairs",
				"minecraft:spruce_stairs",
				"minecraft:jungle_stairs",
				"minecraft:acacia_stairs",
				"minecraft:dark_oak_stairs",
				"minecraft:crimson_stairs",
				"minecraft:warped_stairs",
				"minecraft:mangrove_stairs",
				"minecraft:crimson_stairs",
				"minecraft:warped_stairs",
				"minecraft:crimson_button",
				"minecraft:crimson_wall_sign",
				"minecraft:warped_planks",
				"minecraft:warped_stem",
				"minecraft:stripped_warped_stem",
				"minecraft:stripped_warped_hyphae",
				"minecraft:warped_hyphae",
				"minecraft:warped_slab",
				"minecraft:warped_pressure_plate",
				"minecraft:warped_fence",
				"minecraft:warped_trapdoor",
				"minecraft:warped_fence_gate",
				"minecraft:warped_button",
				"minecraft:warped_door",
				"minecraft:warped_wall_sign",
				"minecraft:crimson_door",
				"minecraft:loom",
				"minecraft:trapped_chest",
				"minecraft:lectern",
				"minecraft:bookshelf",
				"minecraft:composter",
				"minecraft:jukebox",
				"minecraft:soul_campfire",
				"minecraft:campfire",
				"minecraft:bee_nest",
				"minecraft:beehive",
				"minecraft:cartography_table",
				"minecraft:scaffolding",
				"minecraft:noteblock"
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
