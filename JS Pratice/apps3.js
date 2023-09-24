// Question 1
function showRating(rating) {
    let ratings = ""
    for(i = 0; i < Math.floor(rating); i++) {
        ratings += '*'
        if (i !== Math.floor(rating) - 1) {
            ratings += " "
        }
    }
    if (!Number.isInteger(rating)) {
        ratings += ' .'
    }
    return ratings
}
console.log(showRating(3.5))