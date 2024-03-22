const container = document.getElementById('calendar');
const options = {
  defaultView: 'week',
  usageStatistics: false,
  useFormPopup: true,
  useDetailPopup: true,
  calendars: [
    {
      id: 'cal1',
      name: 'Personal',
      backgroundColor: '#03bd9e',
    },
    {
      id: 'cal2',
      name: 'Work',
      backgroundColor: '#00a9ff',
    },
  ],
};

const calendar = new window.Calendar(container, options);

getAllEvents()


calendar.on('beforeCreateEvent', (eventObj) => {

  const eventId = new Date().getTime()
  
  window.axios.post('api/calendar/store', {eventId, ...eventObj}).then(() => {
    calendar.createEvents([
      {
          id: eventId,
          calendarId: eventObj.calendarId,
          title: eventObj.title,
          start: Date.parse(eventObj.start),
          end: Date.parse(eventObj.end),
      }
    ]);
  })

    
});

calendar.on('beforeDeleteEvent', (eventObj) => {


  window.axios.post('api/calendar/delete', {id: eventObj.id}).then(() => {
    calendar.deleteEvent(eventObj.id, eventObj.calendarId);
  })

    
});


calendar.on('beforeUpdateEvent', (eventObj) => {


  window.axios.post('api/calendar/update', eventObj.event).then(() => {
    calendar.updateEvent(eventObj.event.id, eventObj.event.calendarId, eventObj.changes);
  })

    
});

function getAllEvents(){
  window.axios.get('api/calendar/all').then((res) => {
    const data = res.data
    const events = []

    for (let i = 0; i < data.length; i++) {
      const el = {...data[i]}
      el.id = el.eventId
      el.start = new Date(el.start)
      el.end = new Date(el.end)
      events.push(el)
    }

    calendar.createEvents(events);
  })
}