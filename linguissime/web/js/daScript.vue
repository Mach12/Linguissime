var jsondata = {
	"name" : "Exercice test",
	"description" : "blabla",
	"duration" : 1,
	"difficulty" : "Easy",
	"exercisecomponent" : [{
			"type" : "1",
			"data" : [{
					"text" : "Voiture",
					"translation" : "Car",
					"bad-translations" : [
						"poot",
						"sandvich",
						"sasha"
					]
				}
			]
		}, {
			"type" : "2",
			"data" : [{
					"text" : [
						"My brother and I will meet ",
						" the zoo and eat ice cream",
						" together."
					],
					"blanks" : [
						"at",
						""
					]
				}
			]
		}
	]
};

Vue.config.debug = true;
Vue.config.devtools = true;
Vue.config.delimiters = ['<[', ']>'];

/*
 **	Find translation component
 */
Vue.component('find-translation-exercise', {
	template : '#find-translation-template',
	props : ['question'],
	computed : {
		allTranslations : function () {
			var retVal = this.question['bad-translations'].slice(0);
			retVal.push(this.question.translation);
			return retVal;
		},
		shuffledTranslations : function () {
			return shuffle(this.allTranslations);
		},
		goodTranslation : function () {
			return this.question.translation;
		}
	},
	methods : {
		testAnswer : function (answer) {
			if (answer == this.goodTranslation) {
				this.$parent.score += 1;
				this.$parent.next();
			} else {
				alert("fail");
			}
		}
	}
});

/*
 **	Fill in the blanks component
 */
Vue.component('fill-blanks-exercise', {
	template : '#fill-blanks-template',
	props : ['question'],
	data : function () {
		return {
			fillBlanksInput : []
		};
	},
	methods : {
		testAnswer : function () {
			var inputs = this.fillBlanksInput;
			var answers = this.question.blanks;
			var correct = true;

			answers.forEach(function (answer, index) {
				if (answer != inputs[index]) {
					correct = false;
				}
			});

			if (correct) {
				this.$parent.score += 1;
				this.$parent.next();
			} else {
				alert('fail');
			}
		},
		adjustBlanksArray : function () {
			if (this.question.blanks.length != this.fillBlanksInput.length) {
				this.fillBlanksInput.length = this.question.blanks.length;
				this.fillBlanksInput.fill("");
			}
		}
	},
	ready : function () {
		console.log("Ready has been called");
		this.adjustBlanksArray();
	}
});

/*
 ** Vue instance of the thing
 */
var coursVue = new Vue({
		el : '#cours',
		data : {
			currentExerciseID : 0,
			currentExerciseDataID : 0,
			exerciseList : jsondata.exercisecomponent,
			score : 0
		},
		computed : {
			exercise : function () {
				return this.exerciseList[this.currentExerciseID];
			},
			exerciseDataArray : function () {
				return this.exercise.data;
			},
			exerciseData : function () {
				return this.exerciseDataArray[this.currentExerciseDataID];
			},
			exerciseType : function () {
				var exerciseType = this.exercise.type;
				return exerciseType;
			},
			isFinished : function () {
				return this.currentExerciseID >= this.exerciseList.length;
			}
		},
		methods : {
			next : function () {
				this.currentExerciseDataID += 1;
				if (this.currentExerciseDataID >= this.exercise.data.length) {
					this.currentExerciseDataID = 0;
					this.currentExerciseID += 1;
				}
				if (this.isFinished) {
					this.onFinished();
				}
			},
			onFinished : function () {
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function () {
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						alert("Score final: " + this.score);
					}
				};
				xhttp.open("POST", "coursClear.php?score="
					 + this.score + "&name=" + jsondata.name
					 + "&date=" + new Date().mmddyyyy(), true);
				xhttp.send();
				alert("Donn\351es:"
					 + "\nScore: " + this.score
					 + "\nNom: " + jsondata.name
					 + "\nDate: " + new Date().mmddyyyy());
			}
		}
	});

/*
 **	Utilities
 */
function shuffle(array) {
	var currentIndex = array.length,
	temporaryValue,
	randomIndex;

	// While there remain elements to shuffle...
	while (0 !== currentIndex) {

		// Pick a remaining element...
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;

		// And swap it with the current element.
		temporaryValue = array[currentIndex];
		array[currentIndex] = array[randomIndex];
		array[randomIndex] = temporaryValue;
	}

	return array;
};
Date.prototype.mmddyyyy = function () {
	var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
	var dd = this.getDate().toString();
	var yyyy = this.getFullYear().toString();
	return (mm[1] ? mm : "0" + mm[0]) + (dd[1] ? dd : "0" + dd[0]) + yyyy; // padding
};
