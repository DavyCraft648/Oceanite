<?php

namespace DavyCraft648\Oceanite;

use customiesdevs\customies\item\CustomiesItemFactory;
use DavyCraft648\Oceanite\item\armor\OceaniteArmor;
use DavyCraft648\Oceanite\item\armor\OceaniteBoots;
use DavyCraft648\Oceanite\item\armor\OceaniteChestplate;
use DavyCraft648\Oceanite\item\armor\OceaniteHelmet;
use DavyCraft648\Oceanite\item\armor\OceaniteLeggings;
use DavyCraft648\Oceanite\item\OceaniteIngot;
use pocketmine\crafting\ExactRecipeIngredient;
use pocketmine\crafting\ShapedRecipe;
use pocketmine\crafting\ShapelessRecipe;
use pocketmine\crafting\ShapelessRecipeType;
use pocketmine\item\VanillaItems;
use pocketmine\plugin\ApiVersion;
use pocketmine\resourcepacks\ZippedResourcePack;
use pocketmine\scheduler\ClosureTask;
use pocketmine\VersionInfo;
use Symfony\Component\Filesystem\Path;
use function array_merge;
use function strtolower;

final class Main extends \pocketmine\plugin\PluginBase{

	protected function onLoad() : void{
		$this->saveDefaultConfig();
		$this->saveResource("Oceanite [RP] V1.0.mcpack");
		$newPack = new ZippedResourcePack(Path::join($this->getDataFolder(), "Oceanite [RP] V1.0.mcpack"));
		$rpManager = $this->getServer()->getResourcePackManager();
		if(VersionInfo::BASE_VERSION[0] === "5" || ApiVersion::isCompatible(VersionInfo::BASE_VERSION, ["4.13.0"])){
			$rpManager->setResourceStack($rpManager->getResourceStack() + [$newPack]);
		}else{ // TODO: Remove this after 4.13.0 released
			$resourcePacks = new \ReflectionProperty($rpManager, "resourcePacks");
			$resourcePacks->setAccessible(true);
			$resourcePacks->setValue($rpManager, array_merge($resourcePacks->getValue($rpManager), [$newPack]));
			$uuidList = new \ReflectionProperty($rpManager, "uuidList");
			$uuidList->setAccessible(true);
			$uuidList->setValue($rpManager, $uuidList->getValue($rpManager) + [strtolower($newPack->getPackId()) => $newPack]);
		}
		$serverForceResources = new \ReflectionProperty($rpManager, "serverForceResources");
		$serverForceResources->setAccessible(true);
		$serverForceResources->setValue($rpManager, true);

		CustomiesItemFactory::getInstance()->registerItem(OceaniteIngot::class, "seanite:netherite_ingot", "Oceanite Ingot");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteBoots::class, "heavy:seanite_boots", "Oceanite Boots");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteChestplate::class, "heavy:seanite_chestplate", "Oceanite Chestplate");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteHelmet::class, "heavy:seanite_helmet", "Oceanite Helmet");
		CustomiesItemFactory::getInstance()->registerItem(OceaniteLeggings::class, "heavy:seanite_leggings", "Oceanite Leggings");

		if($this->getConfig()->get("register-recipes", true)){
			$this->getScheduler()->scheduleDelayedTask(new ClosureTask(function() : void{
				$oceaniteIngot = CustomiesItemFactory::getInstance()->get("seanite:netherite_ingot");
				$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
					[
						"CBC",
						"BAB",
						"CBC"
					],
					[
						"A" => VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient(VanillaItems::HEART_OF_THE_SEA()) : VanillaItems::HEART_OF_THE_SEA(),
						"B" => VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient(VanillaItems::PRISMARINE_SHARD()) : VanillaItems::PRISMARINE_SHARD(),
						"C" => VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient(VanillaItems::GOLD_INGOT()) : VanillaItems::GOLD_INGOT()
					],
					[$oceaniteIngot]
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient(VanillaItems::DIAMOND_BOOTS()) : VanillaItems::DIAMOND_BOOTS(),
						VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient($oceaniteIngot) : clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("heavy:seanite_boots")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient(VanillaItems::DIAMOND_CHESTPLATE()) : VanillaItems::DIAMOND_CHESTPLATE(),
						VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient($oceaniteIngot) : clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("heavy:seanite_chestplate")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient(VanillaItems::DIAMOND_HELMET()) : VanillaItems::DIAMOND_HELMET(),
						VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient($oceaniteIngot) : clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("heavy:seanite_helmet")],
					ShapelessRecipeType::CRAFTING()
				));
				$this->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe(
					[
						VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient(VanillaItems::DIAMOND_LEGGINGS()) : VanillaItems::DIAMOND_LEGGINGS(),
						VersionInfo::BASE_VERSION[0] === "5" ? new ExactRecipeIngredient($oceaniteIngot) : clone $oceaniteIngot
					],
					[CustomiesItemFactory::getInstance()->get("heavy:seanite_leggings")],
					ShapelessRecipeType::CRAFTING()
				));
			}), 2);
		}
	}

	protected function onEnable() : void{
		if(VersionInfo::BASE_VERSION[0] === "4"){ // use pm5 pls, this is too cursed for me
			$this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function() : void{
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
}
