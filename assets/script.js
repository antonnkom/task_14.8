function getTimeRemaining(endtime)
{
    let total = Date.parse(endtime) - Date.parse(new Date());
    let seconds = Math.floor((total / 1000) % 60);
    let minutes = Math.floor((total / 1000 / 60) % 60);
    let hours = Math.floor((total / (1000 * 60 * 60)) % 24);

    return {
      'total': total,
      'hours': hours,
      'minutes': minutes,
      'seconds': seconds
    };
}
   
function getTimer(elem, endTime)
{
    let daysSpan = elem.querySelector('.days');
    let hoursSpan = elem.querySelector('.hours');
    let minutesSpan = elem.querySelector('.minutes');
    let secondsSpan = elem.querySelector('.seconds');
   
    function updateTimer()
    {
        let t = getTimeRemaining(endTime);
   
        hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
        minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
        secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
   
        if (t.total <= 0) {
            clearInterval(timeInterval);
        }
    }
   
    updateTimer();
    let timeInterval = setInterval(updateTimer, 1000);
  }

function getCookie(name)
{
    let cookies = document.cookie.split('; ');

    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].split('=');

        if (name === cookie[0]) {
            return cookie[1];
        }
    }
}

function replaceAll(str, search, replace)
{
    return str.split(search).join(replace);
}

let timeLogin = replaceAll(getCookie('timein').replace('%20', ' '), '%3A', ':');
console.log(timeLogin);
let endTimeOfAction = new Date(Date.parse(new Date(timeLogin)) + 15 * 24 * 60 * 60 * 1000);
const timerBlock = document.querySelector('#timer');
getTimer(timerBlock, endTimeOfAction);
  