<?php
declare(strict_types=1);

namespace DavyCraft648\Oceanite\item\armor;

use pocketmine\entity\Living;

interface OceaniteArmor{
	public function onTickWorn(Living $entity) : bool;
}
