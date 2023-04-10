<?php
declare(strict_types=1);

namespace DavyCraft648\Oceanite\item\armor;

use customiesdevs\customies\item\component\KnockbackResistanceComponent;
use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Living;
use pocketmine\inventory\ArmorInventory;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\ItemIdentifier;

class OceaniteLeggings extends \pocketmine\item\Armor implements \customiesdevs\customies\item\ItemComponents, OceaniteArmor{
	use ItemComponentsTrait;

	public function __construct(ItemIdentifier $identifier, string $name = "Unknown"){
		parent::__construct($identifier, $name, new ArmorTypeInfo(7, 555, ArmorInventory::SLOT_LEGS));
		$this->initComponent("oceanite_leggings", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT, CreativeInventoryInfo::GROUP_LEGGINGS));
		$this->addComponent(new KnockbackResistanceComponent(0.2));
	}

	public function onTickWorn(Living $entity) : bool{
		if($entity->isUnderwater()){
			$entity->getEffects()->remove(VanillaEffects::MINING_FATIGUE());
		}
		$entity->getEffects()->remove(VanillaEffects::DARKNESS());
		return true;
	}
}
