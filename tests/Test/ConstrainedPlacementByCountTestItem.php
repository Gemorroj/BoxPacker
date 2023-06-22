<?php
/**
 * Box packing (3D bin packing, knapsack problem).
 *
 * @author Doug Wright
 */
declare(strict_types=1);

namespace DVDoug\BoxPacker\Test;

use DVDoug\BoxPacker\ConstrainedPlacementItem;
use DVDoug\BoxPacker\PackedBox;
use DVDoug\BoxPacker\PackedItem;

use function array_filter;
use function count;
use function iterator_to_array;

class ConstrainedPlacementByCountTestItem extends TestItem implements ConstrainedPlacementItem
{
    public static int $limit = 3;

    /**
     * Hook for user implementation of item-specific constraints, e.g. max <x> batteries per box.
     */
    public function canBePacked(
        PackedBox $packedBox,
        int $proposedX,
        int $proposedY,
        int $proposedZ,
        int $width,
        int $length,
        int $depth
    ): bool {
        $alreadyPackedType = array_filter(
            iterator_to_array($packedBox->getItems(), false),
            fn (PackedItem $item) => $item->getItem()->getDescription() === $this->getDescription()
        );

        return count($alreadyPackedType) + 1 <= static::$limit;
    }
}
