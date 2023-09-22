// Loops
// DRY Don't repeat yourself 

// While 
// let count = 1

// while (count <= 5) {
//     console.log(count)
//     count += 1 
// }

// for loop
// for (let i = 0; i < 5; i++) {
//     console.log(i + 1)
// }

// change based on whats divisible 
// for (i = 1; i <= 20; i++) {
//     if (i % 3 == 0 && i % 5 ==0) {
//         console.log(`${i} ~ Frontend Simplified`)
//     }
//     else if (i % 3 == 0) {
//         console.log(`${i} ~ Frontend`)
//     }
//     else if (i % 5 == 0) {
//         console.log(`${i} ~ Simplified`)
//     } else {
//         console.log(`${i} ~ ${i}`)
//     }
// }

// print out every single index
// let str = "Frontend Simplified"
// for (i = 0; i < str.length; i++){
//     console.log(str[i])
// }


function sumOfTwo(num1, num2) {
   return num1 / num2
}

console.log(sumOfTwo(36, 6))

function convert(celc) {
    return celc * 1.8 + 32
}

// // Second way with function
// const convert = (celc) => {
//     return celc * 1.8 + 32
// }


console.log(convert(0))

// Arrays 
let arr = [20, 30, 40, 50, 100]
console.log(arr[0])
console.log(arr[arr.length - 1])

// push a item into a array
arr.push(200)
console.log(arr)

let newArray = arr.filter(element => element < 50)
console.log(newArray)

// FIlter out fail grades 
let grades = ['A', 'FAIL']
// let newGrade = grades.filter(element => element !== "FAIL")
// console.log(newGrade)

let goodGrades = []
for (i = 0; i < grades.length; i++) {
    if (grades[i] !== "FAIL") {
        goodGrades.push(grades[i])
    }
}
console.log(goodGrades)

// change elements within array with map
let arr2 = [1, 4, 9, 16]
let newArray2 = arr2.map(element =>  1)
console.log(newArray2)

let dollars = [20, 5, 10, 3]
// let cents = dollars.map((element) => element * 100)
// console.log(cents)

let cents = []
for (i = 0; i < dollars.length; i++) {
     cents.push(dollars[i] * 100)
}
console.log(cents)