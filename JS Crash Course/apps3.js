// Objects
let userFirstName = "David";
let userLastName = "Bragg";

let users = [
  {
    username: "David",
    email: "email.com",
    status: "VIP",
    password: "test123",
    discordId: "brag222",
    lessonsCompleted: [0, 1],
  },
];

console.log(users[0].lessonsCompleted.map((elem) => elem * 2));

function logIn(email, password) {
  for (i = 0; i < users.length; i++) {
    if (users[i].email === email) {
      console.log(users[i]);
      if (users[i].password === password) {
        console.log("Man is in");
      } else {
        console.log("pass is wrong");
      }
      return;
    }
  }
  console.log("Nothing matchea");
}
logIn("emaisl.com", "test123");

function newRegister(user) {
  users.push(user);
}

newRegister({
  username: "mi",
  email: "san.com",
  status: "vip",
  password: "pass",
  discordId: "dogebats",
  lessonsCompleted: [1],
});
console.log(users);
