<?php
declare(strict_types=1);

namespace DavyCraft648\Oceanite\item;

use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\item\ItemIdentifier;

class OceaniteIngot extends \pocketmine\item\Item implements \customiesdevs\customies\item\ItemComponents{
	use ItemComponentsTrait;

	public function __construct(ItemIdentifier $identifier, string $name = "Unknown"){
		parent::__construct($identifier, $name);
		$this->initComponent("oceanite_ingot", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_ITEMS));
	}

	public function isFireProof() : bool{
		return true;
	}
}
