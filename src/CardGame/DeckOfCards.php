<?php

namespace App\CardGame;

class DeckOfCards
{
    protected $value;
    protected $value1;
    protected $value2;
    protected $value3;
    protected $value4;

    public function getValue(): array
    {
        return $this->value = ['[A♠]','[2♠]','[3♠]','[4♠]','[5♠]','[6♠]','[7♠]','[8♠]','[9♠]','[10♠]','[J♠]','[Q♠]','[K♠]','[A♡]','[2♡]','[3♡]','[4♡]','[5♡]','[6♡]','[7♡]','[8♡]','[9♡]','[10♡]','[J♡]','[Q♡]','[K♡]','[A♢]','[2♢]','[3♢]','[4♢]','[5♢]','[6♢]','[7♢]','[8♢]','[9♢]','[10♢]','[J♢]','[Q♢]','[K♢]','[A♣]','[2♣]','[3♣]','[4♣]','[5♣]','[6♣]','[7♣]','[8♣]','[9♣]','[10♣]','[J♣]','[Q♣]','[K♣]'];
    }

    public function getValueSpades(): string
    {
        return $this->value1 = "[A♠],[2♠],[3♠],[4♠],[5♠],[6♠],[7♠],[8♠],[9♠],[10♠],[J♠],[Q♠],[K♠]";
    }

    public function getValueHearts(): string
    {
        return $this->value2 = "[A♡],[2♡],[3♡],[4♡],[5♡],[6♡],[7♡],[8♡],[9♡],[10♡],[J♡],[Q♡],[K♡]";
    }

    public function getValueDiamonds(): string
    {
        return $this->value3 = "[A♢],[2♢],[3♢],[4♢],[5♢],[6♢],[7♢],[8♢],[9♢],[10♢],[J♢],[Q♢],[K♢]";
    }

    public function getValueClubs(): string
    {
        return $this->value4 = "[A♣],[2♣],[3♣],[4♣],[5♣],[6♣],[7♣],[8♣],[9♣],[10♣],[J♣],[Q♣],[K♣]";
    }

}
