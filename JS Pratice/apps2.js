// Medium 

// Question 1 
function filterOutEasy(num1, num2) {
    return !num1 ? num1 : num2 
}
console.log(filterOutEasy(false, 500))

// Question 2
function arrLength(arr) {
    return arr.length 
}
console.log(arrLength([]))

// Question 3
function lastElement(arr) {
    return arr[arr.length - 1]
}
console.log(lastElement([3, 2, 5, 7]))

// Question 4
function arrSum(arr) {
    sum = 0
    for (i = 0; i < arr.length; i++) {
      sum += arr[i]
    }
    return sum
}
console.log(arrSum([0, -5, -10]))

// Question 5
function progressiveSum(num) {
    sum = 0
    for (i = 1; i <= num; i++) {
        sum += i
    }
    return sum
}
console.log(progressiveSum(600))

// Question 6
function calcTime(seconds) {
    minutes = Math.floor(seconds / 60)
    seconds = seconds % 60  
    if (minutes.toString().length === 1) {
        minutes = '0' + minutes
    }
    return `${minutes}:${seconds}` 
}
console.log(calcTime(70))

// Question 7 
function getMax(arr) {
    max = arr[0]
    for (i = 1; i < arr.length; i++) {
        if (max < arr[i]) {
            max = arr[i]
        }
    }
    return max
}
console.log(getMax([5, 100, 0]))

//  Question 8 
function reverseString(str) {
    // Incrementing 
    // let reverse = ''
    // for(i = 0; i < str.length; i++) {
    //     reverse = str[i] + reverse
    // }
    // return reverse

    // Reverse
    return str.split('').reverse().join('')
}
console.log(reverseString('abc'))

// Question 9 
function convertToZero(arr) {
    return arr.map((elem) => 0)

    // newArr = []
    // for(i = 0; i < arr.length; i++) {
    //    newArr.push(arr[i] * 0)
    // }
    // return newArr

    // return new Array(arr.length). fill(0)
}
console.log(convertToZero([5, 10, 0, 1]))

// Question 10
function removeApples(arr) {
    // return arr.filter(elem => elem !== 'Apple')
    newArray = []
    for (i =0;i < arr.length; i++) {
        if (arr[i] !== 'Apple') {
            newArray.push(arr[i])
        }
    } 
    return newArray
}

console.log(removeApples(['Apple','Bananas', 'Orange', 'Apple']))

// Question 11
function filterOutFalsy(arr) {
    // return arr.filter((elem) => !!elem === true)
    newArray=[]
    for(i = 0; i < arr.length; i++) {
        if (!!arr[i] === true)
        newArray.push(arr[i])
    }
    return newArray
}
console.log(filterOutFalsy(['', 0, 'Orangs', 'Toms', false]))

// Question 12
function covertToBoolean(arr) {
    // return arr.map(elem => !!elem)

    newArray = []
    for (i = 0; i < arr.length; i++ ) {
        newArray.push(!!arr[i])
    }
    return newArray
}
console.log(covertToBoolean([500, 0, "David", "", []]))