// Question 1
function addTwo(num1, num2) {
    return num1 + num2
}

console.log(addTwo(3, 7))

//  Question 2
function hoursIntoSeconds(hours) {
    return hours * 60 * 60
}

console.log(hoursIntoSeconds(24))

// Question 3
function calcPermimeter(len, wid) {
    return (len * 2) + (wid * 2)
}
console.log(calcPermimeter(2,9));

// Question 4
function calcTriangleArea(base, height) {
    return 0.5 * base * height
}
console.log(calcTriangleArea(20, 20))

//  Question 5
function addFrontend(str) {
    return str + 'Frontend'
}
console.log(addFrontend('Banana'))

// question 6
function sumGreaterThan100(num1, num2) {
    return num1 + num2 > 100 
}
console.log(sumGreaterThan100(50, 2))

//  Question 7
function lessThanZero(num) {
    return num <= 0
}
console.log(lessThanZero(-2))

// Question 8
function oppositeBoolean(bool) {
    return !bool
}
console.log(oppositeBoolean(true))

// Question 9
function isNotZero(num) {
    return num !== 0
}
console.log(isNotZero(5))

// Question 10

function calcRemainder(num1, num2) {
    return num1 % num2
}
console.log(calcRemainder(9, 8))

// Question 11 
function isOdd(num) {
    return num % 2 !== 0
}
console.log(isOdd(1))

// Question 12
function booleanInteger(num) {
    return num % 2 === 0 ? 1 : -1
}
console.log(booleanInteger(5)) 

// Question 13
function isLoggedAndSub(logged, subbed) {
    return logged === 'LOGGED__IN' || subbed === 'SUBSCRIBED'
}
console.log(isLoggedAndSub('LOGGED__IN', 'SUBSCRIBED'))

