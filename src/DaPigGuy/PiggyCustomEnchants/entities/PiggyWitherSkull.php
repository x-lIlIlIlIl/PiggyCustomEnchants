<?php

declare(strict_types=1);

namespace DaPigGuy\PiggyCustomEnchants\entities;

use DaPigGuy\PiggyCustomEnchants\utils\AllyChecks;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\math\RayTraceResult;
use pocketmine\network\mcpe\protocol\types\entity\EntityLegacyIds;
use pocketmine\player\Player;

/**
 * Class PiggyWitherSkull
 * @package DaPigGuy\PiggyCustomEnchants\entities
 */
class PiggyWitherSkull extends PiggyProjectile
{
    const NETWORK_ID = EntityLegacyIds::WITHER_SKULL;

    /** @var float */
    public $width = 0.5;
    /** @var float */
    public $length = 0.5;
    /** @var float */
    public $height = 0.5;

    /** @var float */
    protected $drag = 0.01;
    /** @var float */
    protected $gravity = 0.05;

    /** @var int */
    protected $damage = 0;

    /**
     * @param Entity $entityHit
     * @param RayTraceResult $hitResult
     */
    public function onHitEntity(Entity $entityHit, RayTraceResult $hitResult): void
    {
        if ($entityHit instanceof Living) {
            $owner = $this->getOwningEntity();
            if (!$owner instanceof Player || !AllyChecks::isAlly($owner, $entityHit)) {
                $effect = new EffectInstance(VanillaEffects::WITHER(), 800, 1);
                $entityHit->getEffects()->add($effect);
            }
        }
        parent::onHitEntity($entityHit, $hitResult);
    }
}