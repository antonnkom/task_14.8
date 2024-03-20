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
   
  let endTimeOfAction = new Date(Date.parse(new Date('2024-03-20 01:00:00')) + 15 * 24 * 60 * 60 * 1000);
  const timerBlock = document.querySelector('#timer');
  getTimer(timerBlock, endTimeOfAction);
  