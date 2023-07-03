//alert("world");

const person = {first_name:"Milecky", last_name:"Avalon"};
console.log(person.first_name);
//console.log(person["last_name"]);

const cars = ["Audi", "BMW", "Mercedes"];
//console.log(cars);
//console.log(cars[1]);
cars[cars.length] = "Volvo";
console.log(cars);

function hello (){
    alert("Hello from my first js function");
}

let list = '<ul>';
for (var i = 0; i<cars.length; i++){
    list+= '<li>' + cars[i] + '</li>';
}
list+= '</ul>';
console.log(list);
document.getElementById('cars').innerHTML = list;


