<?php

/**
 * Get a random item from a list
 *
 * @param array $list
 * @return mixed
 */
function getRandomItem($list) {
    $count = count($list);
    $randomIndex = rand(0, $count - 1);
    return $list[$randomIndex];
}