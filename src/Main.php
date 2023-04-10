<?php
declare(strict_types=1);

namespace DavyCraft648\Oceanite;

use customiesdevs\customies\item\CustomiesItemFactory;
use DavyCraft648\Oceanite\item\armor\OceaniteArmor;
use DavyCraft648\Oceanite\item\armor\OceaniteBoots;
use DavyCraft648\Oceanite\item\armor\OceaniteChestplate;
use DavyCraft648\Oceanite\item\armor\OceaniteHelmet;
use DavyCraft648\Oceanite\item\armor\OceaniteLeggings;
use DavyCraft648\Oceanite\item\OceaniteIngot;
use DavyCraft648\Oceanite\item\tool\OceaniteAxe;
use DavyCraft648\Oceanite\item\tool\OceaniteHoe;
use DavyCraft648\Oceanite\item\tool\OceanitePickaxe;
use DavyCraft648\Oceanite\item\tool\OceaniteShovel;
use DavyCraft648\Oceanite\item\tool\OceaniteSword;
use pocketmine\crafting\ShapedRecipe;
use pocketmine\crafting\ShapelessRecipe;
use pocketmine\crafting\ShapelessRecipeType;
use pocketmine\item\VanillaItems;
use pocketmine\resourcepacks\ZippedResourcePack;
use pocketmine\scheduler\ClosureTask;
use Symfony\Component\Filesystem\Path;
use function array_merge;

final class Main extends \pocketmine\plugin\PluginBase{

	protected function onLoad() : void{
		$this->saveDefaultConfig();
		$this->saveResource("Oceanite V1.1.mcpack");
		$rpManager = $this->getServer()->getResourcePackManager();
		$rpManager->setResourceStack(array_merge($rpManager->getResourceStack(), [new ZippedResourcePack(Path::join($this->getDataFolder(), "Oceanite V1.1.mcpack"))]));
		$serverForceResources = new \ReflectionProperty($rpManager, "serverForceResources");
		$serverForceResources->setAccessible(true);
		$serverForceResources->setValue($rpManager, true);

		CustomiesItemFactory::getInstance()->registerItem(OceaniteIngot::class, "oceanite:oceanite_ingot", "Oceanite Ingot");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteBoots::class, "oceanite:oceanite_boots", "Oceanite Boots");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteChestplate::class, "oceanite:oceanite_chestplate", "Oceanite Chestplate");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteHelmet::class, "oceanite:oceanite_helmet", "Oceanite Helmet");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteLeggings::class, "oceanite:oceanite_leggings", "Oceanite Leggings");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteAxe::class, "oceanite:oceanite_axe", "Oceanite Axe");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteHoe::class, "oceanite:oceanite_hoe", "Oceanite Hoe");
		CustomiesItemFactory::getInstance()->registerItem(OceanitePickaxe::class, "oceanite:oceanite_pickaxe", "Oceanite Pickaxe");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteShovel::class, "oceanite:oceanite_shovel", "Oceanite Shovel");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteSword::class, "oceanite:oceanite_sword", "Oceanite Sword");

		if($this->getConfig()->get("register-recipes", true)){
			$this->getScheduler()->scheduleDelayedTask(new ClosureTask(function() : void{
				$oceaniteIngot = CustomiesItemFactory::getInstance()->get("oceanite:oceanite_ingot");
				$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
					[
						"CBC",
						"BAB",
						"CBC"
					],
					[
						"A" => VanillaItems::HEART_OF_THE_SEA(),
						"B" => VanillaItems::PRISMARINE_SHARD(),
						"C" => VanillaItems::GOLD_INGOT()
					],
					[$oceaniteIngot]
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VanillaItems::DIAMOND_BOOTS(),
						clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("oceanite:oceanite_boots")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VanillaItems::DIAMOND_CHESTPLATE(),
						clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("oceanite:oceanite_chestplate")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VanillaItems::DIAMOND_HELMET(),
						clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("oceanite:oceanite_helmet")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VanillaItems::DIAMOND_LEGGINGS(),
						clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("oceanite:oceanite_leggings")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VanillaItems::DIAMOND_AXE(),
						clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("oceanite:oceanite_axe")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VanillaItems::DIAMOND_HOE(),
						clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("oceanite:oceanite_hoe")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VanillaItems::DIAMOND_PICKAXE(),
						clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("oceanite:oceanite_pickaxe")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VanillaItems::DIAMOND_SHOVEL(),
						clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("oceanite:oceanite_shovel")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VanillaItems::DIAMOND_SWORD(),
						clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("oceanite:oceanite_sword")],
					ShapelessRecipeType::CRAFTING()
				));
			}), 2);
		}

		$this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function() : void{
			if($this->getServer()->getTicksPerSecond() < 17){
				return;
			}
			foreach($this->getServer()->getOnlinePlayers() as $player){
				foreach($player->getArmorInventory()->getContents() as $item){
					if($item instanceof OceaniteArmor){
						$item->onTickWorn($player);
					}
				}
			}
		}), 20);
	}
}
