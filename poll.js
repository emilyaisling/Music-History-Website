function getVote(int) 
{
    let request = new XMLHttpRequest();
    request.onreadystatechange = function ()
    {
        if (request.readyState == 4 && status == 200)
        {
            document.getElementsByClassName('poll').innerHTML=requext.responseText;
        }
    }
    request.open('GET', 'poll.php?vote='+int, true);
    request.send();
}
