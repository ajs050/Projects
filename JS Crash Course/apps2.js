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
//     if (i % 3 === 0 && i % 5 === 0) {
//         console.log(`${i} ~ Frontend Simplified`)
//     }
//     else if (i % 3 === 0) {
//         console.log(`${i} ~ Frontend`)
//     }
//     else if (i % 5 === 0) {
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