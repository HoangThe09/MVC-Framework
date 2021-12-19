function symmetricPrime(n){
    var check = 0;
    var num = 2;
    while(check < n){
        if(checkPrime(num)){
            var numString = num.toString();
            var numReverse = '';
            for (let i = numString.length - 1; i >= 0; i--) {
                numReverse += numString[i];
            }
            if(num == numReverse){
                check++
                if(check == n){
                    return numReverse;
                }
            }
        }
        num++;
    }
}

function checkPrime(n){
    for(var i = 2; i < Math.sqrt(n); i++){
        if(n % i == 0){
            return false
        }
    }
    return true;
}
var a = symmetricPrime(3);
console.log(a)
// var num = 15;
// var numString = num.toString();
// var numReverse = '';
// for (let i = numString.length - 1; i >= 0; i--) {
//     numReverse += numString[i];
// }
// console.log(numReverse);