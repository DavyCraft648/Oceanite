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

class OceaniteHelmet extends \pocketmine\item\Armor implements \customiesdevs\customies\item\ItemComponents, OceaniteArmor{
	use ItemComponentsTrait;

	public function __construct(ItemIdentifier $identifier, string $name = "Unknown"){
		parent::__construct($identifier, $name, new ArmorTypeInfo(4, 407, ArmorInventory::SLOT_HEAD, 3, true));
		$this->initComponent("oceanite_helmet", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT, CreativeInventoryInfo::GROUP_HELMET));
	}

	public function onTickWorn(Living $entity) : bool{
		if($entity->isUnderwater()){
			$entity->getEffects()->add(new EffectInstance(VanillaEffects::WATER_BREATHING(), 40, 0, false));
		}
		$entity->getEffects()->remove(VanillaEffects::MINING_FATIGUE());
		return false;
	}
}
