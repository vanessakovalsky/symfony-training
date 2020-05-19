<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ScoreFilter extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('score', [$this, 'formatScore'],['is_safe' => ['html']]),
        ];
    }

    public function formatScore($score1, $score2)
    {
        $score = '';
        if ($score1 != $score2) {
            $score_max = max($score1, $score2);
            $score_min = min($score1, $score2);
            $score = '<strong>'.$score_max.'</strong>-'.$score_min;
        }
        else {
            $score = $score1 . '-' . $score2;
        }

        return $score;
    }
}