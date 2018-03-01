	var previous;
	function randomizeNumber() {
		//Randimizes a number between 1 and 6
		return parseInt(Math.floor((Math.random() * 6)+1));
		var random = Math.floor((Math.random() * 14) + 1);
		console.log(random);
		if(random <= 12){
			random /= 3;
			random ++;
		}
		else if( random == 13)
			random = 5;
		else
			random = 6;
		console.log(parseInt(random));
		return parseInt(random);
	}

	function rollDice(diceIndex, side) {
		//Removes old class and adds the new
		var dice;
		if( diceIndex == 1) dice = $('#dice1');
		if( diceIndex == 2) dice = $('#dice2');
		var currentClass = dice.attr('class');
		var newClass = 'show-' + side;
		
		dice.removeClass();
		dice.addClass(newClass);
		
		if (currentClass == newClass) {
			dice.addClass('show-same');
		}
	}
	
	function soundEffect() {
		var audio = $("audio")[0];
		try{
			audio.pause();
			audio.currentTime = 0;
			audio.play();
		} catch(e){
			console.log(e);
		}
	}
	function rollDiceFromNumber(diceIndex,number){
		if (number == 1) { rollDice(diceIndex,'front'); }
		else if (number == 2) { rollDice(diceIndex,'back'); }
		else if (number == 3) { rollDice(diceIndex,'right'); }
		else if (number == 4) { rollDice(diceIndex,'left'); }
		else if (number == 5) { rollDice(diceIndex,'top'); }
		else if (number == 6) { rollDice(diceIndex,'bottom'); }
		// $(".dicNum").html(number);
	}
	function rollDiceNameNumber(name, number1, number2){
		rollDiceFromNumber(1, number1);
		rollDiceFromNumber(2, number2);
		rolledDiceNameNumber(name, number1, number2);
		// $(".dicNum").html(number);
	}
	$('.dice-container').on('click ', function() {
		if(isCanPlay == false){
			alert("It's not your turn.");
			return;
		}
		var number1 = randomizeNumber();
		var number2 = randomizeNumber();
		rollDiceFromNumber(1,number1);
		rollDiceFromNumber(2,number2);
		rolledDice(number1, number2);
		soundEffect();
	});
	