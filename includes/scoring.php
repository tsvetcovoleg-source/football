<?php
/**
 * Returns match outcome: home, draw, or away.
 */
function matchOutcome(int $homeScore, int $awayScore): string
{
    if ($homeScore > $awayScore) {
        return 'home';
    }

    if ($homeScore < $awayScore) {
        return 'away';
    }

    return 'draw';
}

/**
 * Returns goal difference from the home team's perspective.
 */
function goalDifference(int $homeScore, int $awayScore): int
{
    return $homeScore - $awayScore;
}

/**
 * Calculates prediction points.
 * NULL means the real score is not available yet.
 */
function calculatePoints($predHome, $predAway, $realHome, $realAway): ?int
{
    if ($realHome === null || $realAway === null || $realHome === '' || $realAway === '') {
        return null;
    }

    $predHome = (int) $predHome;
    $predAway = (int) $predAway;
    $realHome = (int) $realHome;
    $realAway = (int) $realAway;

    if ($predHome === $realHome && $predAway === $realAway) {
        return 3;
    }

    $predOutcome = matchOutcome($predHome, $predAway);
    $realOutcome = matchOutcome($realHome, $realAway);

    if ($predOutcome === $realOutcome && goalDifference($predHome, $predAway) === goalDifference($realHome, $realAway)) {
        return 2;
    }

    if ($predOutcome === $realOutcome) {
        return 1;
    }

    return 0;
}
