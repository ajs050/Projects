// Question 1
function showRating(ratings) {
  rating = "";
  for (i = 0; i < Math.floor(ratings); i++) {
    rating += "★";
    if (i !== Math.floor(ratings) - 1) {
      rating += " ";
    }
  }
  if (!Number.isInteger(ratings)) {
    rating += " .";
  }
  return rating;
}
console.log(showRating(3.5));

// Question 2
function sortLowToHigh(arr) {
  return arr.sort((a, b) => a - b);
}
console.log(sortLowToHigh([20, 10, 50, 100, 8]));

// Question 3
function HighestToLowest(arr) {
    return arr.sort((a, b) => b.price - a.price)
}
console.log(
  HighestToLowest([
    { id: 1, price: 25 },
    { id: 2, price: 10 },
    { id: 3, price: 70 },
  ])
);

// Question 4
async function postsByUser(userId) {
    // "https://jsonplaceholder.typicode.com/posts"
    const response = await fetch("https://jsonplaceholder.typicode.com/posts");
    const data = await response.json();
    const posts = data.filter((elem) => elem.userId === userId)
    return console.log(posts)
}
(postsByUser(4))

// Question 5
async function postBySingleUser(completed) {
// "https://jsonplaceholder.typicode.com/posts"
    const response = await fetch("https://jsonplaceholder.typicode.com/todos")
    const data = await response.json() 
    const posts = data.filter((elem) => !elem.completed).slice(0, 6)
    console.log(posts)
}
postBySingleUser()
