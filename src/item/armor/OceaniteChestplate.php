<?php
declare(strict_types=1);

namespace DavyCraft648\Oceanite\item\armor;

use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Living;
use pocketmine\inventory\ArmorInventory;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\ItemIdentifier;

class OceaniteChestplate extends \pocketmine\item\Armor implements \customiesdevs\customies\item\ItemComponents, OceaniteArmor{
	use ItemComponentsTrait;

	public function __construct(ItemIdentifier $identifier, string $name = "Unknown"){
		parent::__construct($identifier, $name, new ArmorTypeInfo(9, 592, ArmorInventory::SLOT_CHEST, 3, true));
		$this->initComponent("oceanite_chestplate", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT, CreativeInventoryInfo::GROUP_CHESTPLATE));
	}

	public function onTickWorn(Living $entity) : bool{
		if($entity->isUnderwater()){
			$entity->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 40, 0, false));
		}
		$entity->getEffects()->remove(VanillaEffects::WITHER());
		return false;
	}
}
