// first way of accessing any elements - HTML
document.querySelector('.title').innerHTML += ' Frontend'

// second way, best way for ids
// console.log(document.getElementById('title'))

// change CSS
document.querySelector('.title').style.fontSize = '26px'

function changetoRed() {
    document.querySelector('.title').style.color = 'red'
}