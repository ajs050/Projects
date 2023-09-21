// Data Types

// Strings 
console.log('hi')

// Find first character of string
console.log('Hello World'[0])

// How many characters 
console.log('Frontend Simplified is amazing'.length)
// last index
let str = 'Andrew'
console.log(str[str.length - 1])

// Numbers 
// remainder 
console.log(16 % 5)

// Variables
let fullName = 'Andrew'
let temperature = 20
temperature = temperature + 5
console.log(temperature)

let celsius = 10
let fahrenheit = celsius * 1.8 + 32
console.log(fahrenheit)

// Equality
let bool = '1' == 1
console.log(bool)

let bool1 = '1' === 1
console.log(bool1)

// Conditionals 
let sub = false 
let logIn = false
if (sub === true) {
    console.log('Show vid')
}
else if (logIn === true){
    console.log('upgrade sub')
}
 else {
    console.log("Don't show")    
}

let cash = 100
let price = 200
let change = cash - price
let owe = price - cash
if (cash > price) {
    console.log(`You paid extra, here is your change of $${change}.`)
} 
else if (cash === price) {
    console.log('Paid exact amount')
} else {
    console.log(`Not enough, you owe me $${owe} brokie`)
}

// Operators
let cash1 = 2300
let price1 = 200
let isStoreOpen = false
 if (cash1 >= price1 && !isStoreOpen) {
    console.log('Print receipt')
 }

//  Ternary Operators 
let hot = false
hot ? console.log('Hot') : console.log('Cold')

let subscribed = true
let loggedIn = true
let show = subscribed && loggedIn ? 'Show vid' : `Don't show`
console.log(show)

let cash2 = 50
let price2 = 40
let isStoreOpened = false
let message = cash2 >=  price2 && isStoreOpened ? "Give receipt" : 'Do not give it!'
console.log(message)

