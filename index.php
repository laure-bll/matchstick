#!/usr/bin/php
<?php

class Game
{
	private $max = 11;
	private $sticks = 11;
	private $nbr;
	private $turn = 2;
	private $name = "Player";

	public function __construct()
	{
		echo "\e[1;43mHello, I'm the AI. Let's play to Matchstick !\e[m" . PHP_EOL;
		echo "Do you want to read the rules ? ";
		$this->rules();
		echo "Do you want to choose the number of matches ? ";
		$this->sticks();
		echo "Enter your name : ";
		$this->name();
		echo "\e[1;43mLet's go $this->name !\e[m" . PHP_EOL;
		$this->board();
	}

	public function board()
	{
		if ($this->sticks < $this->max)
		{
			$removed = $this->max - $this->sticks;
			echo str_pad(" ", $removed, " ");
		}

		for($i = 0; $i < $this->sticks; $i++)
		{
			echo "|";
		}

		if ($this->sticks > 0)
		{
			echo " ($this->sticks)" . PHP_EOL;
		}
		else
		{
			echo PHP_EOL;
		}

		$this->checkEnd();
		$this->turn();
	}

	public function turn()
	{
		$player = 1;
		$robot = 2;

		if ($this->turn == $robot)
		{
			$this->turn = $player;
			echo "\e[0;32mYou're turn : \e[m";
			$this->player();
		}
		elseif ($this->turn == $player)
		{
			$this->turn = $robot;
			echo "\e[0;36mAI's turn... \e[m" . PHP_EOL;
			$this->robot();
		}
	}

	public function player()
	{
		echo  "\e[0;32mMatches : \e[m";
		$this->nbr = trim(fgets(STDIN));
		$this->checkErrors();
		$this->sticks -= $this->nbr;
		echo "\e[0;32m$this->name removed $this->nbr match(es)\e[m" . PHP_EOL;
		$this->board();
	}
		
	public function robot()
	{
		sleep(1);

		// recupere les numeros critiques
		if ($this->sticks % 4 == 1 || $this->sticks == 2)
		{
			$this->sticks -= 1;
			echo "\e[0;36mAI removed 1 match(es)\e[m" . PHP_EOL;
		}

		else
		{
			$before = $this->sticks;

			while ($this->sticks % 4 != 1)
			{
				$this->sticks--;
			}

			$removed = $before - $this->sticks;
			echo "\e[0;36mAI removed $removed match(es)\e[m" . PHP_EOL;
		}
		$this->board();
	}

	public function checkEnd()
	{
		if ($this->sticks == 0 && $this->turn == 1)
		{
			sleep(1);
			echo "\e[1;43mYou lost $this->name, too bad...\e[m" . PHP_EOL;
			exit();
		}
		elseif ($this->sticks == 0 && $this->turn == 2)
		{
			sleep(1);
			echo "\e[1;43mI lost... snif... but I'll get you next time $this->name!!\e[m" . PHP_EOL;
			exit();
		}
	}

	public function checkErrors()
	{
		if ($this->nbr < 0  || !is_numeric($this->nbr))
		{
			echo "\e[0;31mError : invalid input (positive number expected)\e[m" . PHP_EOL;
			$this->player();
		}
		elseif ($this->nbr < 1)
		{
			echo "\e[0;31mError : you have to remove at least one match\e[m" . PHP_EOL;
			$this->player();
		}
		elseif ($this->nbr > $this->sticks)
		{
			echo "\e[0;31mError : not enough matches\e[m" . PHP_EOL;
			$this->player();
		}
		elseif ($this->nbr > 3)
		{
			echo "\e[0;31mError : you have to remove at most 3 matches\e[m" . PHP_EOL;
			$this->player();
		}
	}

	public function rules()
	{
		$answer = trim(fgets(STDIN));

		if ($answer == "yes" || $answer == "y")
		{
			echo "\e[0;35mMatchstick is a strategic game for two players. Alternatively they have to remove one, two, or three matches.\e[m" . PHP_EOL . "\e[0;35mThe one who takes the last match failed.\e[m" . PHP_EOL;
		}
		elseif ($answer == "no" ||$answer == "n")
		{
		}
		else
		{
			echo "Please answer 'yes' or 'no' : ";
			$this->rules();
		}
	}

	public function sticks()
	{
		$answer = trim(fgets(STDIN));

		if ($answer == "yes" || $answer == "y")
		{
			echo "Choose a number between 11 and 1000 : ";
			$number = trim(fgets(STDIN));
			
			if($number < "11" || $number > "1000")
			{
				echo "Are you ready to choose a correct number ? ";
				$this->sticks();
			}
			else
			{
				$this->max = $number;
				$this->sticks = $number;
				$this->sticks = $number;
			}
		}
		elseif ($answer == "no" ||$answer == "n")
		{
		}
		else
		{
			echo "Please answer 'yes' or 'no' : ";
			$this->sticks();
		}
	}

	public function name()
	{
		$answer = trim(fgets(STDIN));

		if (!empty($answer))
		{
			$this->name = ucfirst($answer);
		}
		else
		{
			echo "Please choose another name : ";
			$this->name();
		}

	}
}
$new = new Game();