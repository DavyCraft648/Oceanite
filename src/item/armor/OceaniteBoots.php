<?php

namespace DavyCraft648\Oceanite\item\armor;

use customiesdevs\customies\item\component\KnockbackResistanceComponent;
use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Human;
use pocketmine\entity\Living;
use pocketmine\inventory\ArmorInventory;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\ItemIdentifier;

class OceaniteBoots extends \pocketmine\item\Armor implements \customiesdevs\customies\item\ItemComponents, OceaniteArmor{
	use ItemComponentsTrait;

	public function __construct(ItemIdentifier $identifier, string $name = "Unknown"){
		parent::__construct($identifier, $name, new ArmorTypeInfo(4, 577, ArmorInventory::SLOT_FEET, 3, true));
		$this->initComponent("seanite_boots", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT, CreativeInventoryInfo::GROUP_BOOTS));
		$this->addComponent(new KnockbackResistanceComponent(0.2));
	}

	public function onTickWorn(Living $entity) : bool{
		if($entity instanceof Human){
			if($entity->isUnderwater()){
				$entity->getEffects()->add(new EffectInstance(VanillaEffects::HASTE(), 40, 1, false)); // TODO: Add config
			}
			$entity->getEffects()->remove(VanillaEffects::SLOWNESS());
			return true;
		}
		return false;
	}
}
