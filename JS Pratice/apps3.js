// Question 1
function showRating(rating) {
  let ratings = "";
  for (i = 0; i < Math.floor(rating); i++) {
    ratings += "★";
    if (i !== Math.floor(rating - 1)) {
      ratings += " ";
    }
  }
  if (!Number.isInteger(rating)) {
    ratings += " .";
  }
  return ratings;
}
console.log(showRating(3.5));

// Question 2
function sortLowToHigh(arr) {
  return arr.sort((a, b) => a - b);
}
console.log(sortLowToHigh([5, 200, 10, 0, -5]));

// Question 3
function HightToLow(objects) {
    return objects.sort((a, b) => b.price - a.price)
}
console.log(
  HightToLow([
    { id: 1, price: 50 },
    { id: 2, price: 0 },
    { id: 3, price: 500 },
  ])
);
// Question 5

async function callId(id) {
    const response = await fetch("https://jsonplaceholder.typicode.com/posts");
    const data = await response.json()
    const posts = data.filter((elem) => elem.userId === id)
    console.log(posts)
}   
callId(4)

// Question 6
async function firstSixIncomplete(userId) {
    const response = await fetch("https://jsonplaceholder.typicode.com/todos")
    const data = await response.json();
    const completed = data.filter((elem) => !elem.completed).slice(0, 6)
    console.log(completed)
}
firstSixIncomplete()


