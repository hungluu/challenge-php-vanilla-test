(function (exports, $, scheduler, moment, undefined) {
  'use strict'
  
  // CONSTANTS
  var EVENT_STATUS_CANCELLED = 'cancelled'
  var EVENT_STATUS_SCHEDULED = 'scheduled'

  /**
   * Schedule
   * @constructor
   * @property string uri request uri
   * @property int firstHour first hour of schedules
   * @property int lastHour last hour of schedules
   */
  var Schedule = function () {
    this.uri = '/schedule/schedule'
    this.firstHour = 8
    this.lastHour = 17
  }
  
  Schedule.prototype = {
    /**
     * Init schedule list
     * @param {string} selector
     * @param {Date} date
     * @param {string} mode
     */
    init: function (selector, date, mode) {
      var schedule = this
      this.list(function (res) {
        // Init scheduler options
        schedule.firstHour = res.data.first_hour
        schedule.lastHour = res.data.last_hour
        schedule.configSchedulerOptions()
        schedule.customizeSchedulerView()
        schedule.initSchedulerEvents()
        
        // Build HTML
        $(selector).html(schedule.getSchedulerHTML())
        
        // Init scheduler
        scheduler.init('scheduler', date, mode)
        scheduler.parse(res.data.events, 'json')
        
        // Init events
        $('.button-create').click(function () {
          schedule.openLightBox()
        })
      })
    },
    
    /**
     * Open light box
     * @param {int} id
     */
    openLightBox: function (id) {
      if (id) {
        scheduler.showLightbox(id)
      } else {
        // view existing item
        var startDate = moment()
        startDate.set({ 'hour': this.firstHour })
        var endDate = moment()
        endDate.set({ 'hour': this.firstHour + 1 })
        
        // Add event and open light box
        scheduler.addEventNow({
          id: 0,
          start_date: startDate.toDate(),
          end_date: endDate.toDate(),
          name: '',
          status: EVENT_STATUS_SCHEDULED
        })
      }
    },
    
    /**
     * List items
     * @param {function} callback
     * @param {function} errorCallback
     */
    list: function (callback, errorCallback) {
      this.request('GET', {}, callback, errorCallback, 'Can not get schedule list')
    },

    /**
     * Create an item
     * @param {object} attributes
     * @param {function} callback
     * @param {function} errorCallback
     */
    createItem: function (attributes, callback, errorCallback) {
      this.request('POST', attributes, callback, errorCallback, 'Can not create schedule item')
    },

    /**
     * Update an item
     * @param {object} attributes
     * @param {function} callback
     * @param {function} errorCallback
     */
    updateItem: function (attributes, callback, errorCallback) {
      this.request('UPDATE', attributes, callback, errorCallback, 'Can not update schedule item')
    },

    /**
     * Delete a item
     * @param {object} conditions
     * @param {function} callback
     * @param {function} errorCallback
     */
    deleteItem: function (conditions, callback, errorCallback) {
      this.request('DELETE', conditions, callback, errorCallback, 'Can not delete schedule item')
    },

    /**
     * Handle errors
     * @param {Error} err
     */
    handleError: function (err) {
      alert(err.message)
    },

    /**
     * Send request to uri
     * @param {string} method
     * @param {object} data
     * @param {function} callback
     * @param {function} errorCallback
     * @param {function} errorMessage
     */
    request: function (method, data, callback, errorCallback, errorMessage) {
      var schedule = this
      errorMessage = errorMessage || 'Unknown error, please check console log for more detail'
      var onError = function (errorMessage) {
        if (errorCallback) {
          errorCallback()
        }
        schedule.handleError(new Error(errorMessage))
      }
      
      // Send ajax
      $.ajax({
        type: method || 'GET',
        url: this.uri,
        data: data,
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function (res) {
          if (callback && callback(res) === false) {
            // Request succeeds but response validation by callback fails
            onError(errorMessage)
          }
        },
        error: function () {
          // Handle error
          onError(errorMessage)
        }
      })
    },

    /**
     * Config scheduler based on schedule
     * @param schedule
     */
    configSchedulerOptions: function () {
      // Config scheduler
      scheduler.config.multi_day = false
      scheduler.config.xml_date = '%Y-%m-%d %H:%i'
      scheduler.config.limit_time_select = true
      scheduler.config.cascade_event_display = false// true
      scheduler.config.cascade_event_count = 1
      scheduler.config.cascade_event_margin = 30
      scheduler.config.details_on_create = true // show light box when creating
      scheduler.config.dblclick_create = false // disable auto click creation
      scheduler.config.first_hour = this.firstHour
      scheduler.config.last_hour = this.lastHour
      scheduler.config.event_duration = 60
      scheduler.config.auto_end_date = true
  
      // Custom lightbox
      scheduler.config.lightbox.sections = [
        {name: "Name", map_to: "name", type: "textarea", focus: true},
        {
          name: 'Status',
          map_to: 'status',
          type: 'select',
          options: [
            { key: EVENT_STATUS_SCHEDULED, label: EVENT_STATUS_SCHEDULED },
            { key: EVENT_STATUS_CANCELLED, label: EVENT_STATUS_CANCELLED }
          ]
        },
        {name: "time", height: 72, type: "time", map_to: "auto"}
      ]
    },
    
    /**
     * Init scheduler events
     */
    initSchedulerEvents: function () {
      var schedule = this
      scheduler.attachEvent("onDblClick", function (id){
        scheduler.showLightbox(id)
        return false
      })
  
      scheduler.attachEvent("onEventSave", function(id, ev, is_new){
        var name = ev.name.trim()
        if (!name) {
          alert('Please provide item name')
          return false
        }
  
        ev.name = name
        if (is_new) {
          schedule.createItem(ev, function (res) {
            if (res.data.create_count === 0) {
              return false // should trigger error
            }
          }, function () {
            scheduler.showLightbox(id)
          })
        } else {
          schedule.updateItem(ev, function (res) {
            if (res.data.update_count === 0) {
              return false // should trigger error
            }
          }, function () {
            scheduler.showLightbox(id)
          })
        }
        return true
      })
  
      scheduler.attachEvent("onEventDeleted", function(id, ev, is_new){
        if (ev.name === "") {
          // This is a new event
          return true
        }
  
        schedule.deleteItem(ev, function (res) {
          if (res.data.delete_count === 0) {
            return false // should trigger error
          }
        }, function () {
          scheduler.addEvent(ev)
          scheduler.showLightbox(ev.id)
        })
        return true
      })

      scheduler.attachEvent("onBeforeLightbox", function (id){
        var event = scheduler.getEvent(id)
        if (!event) {
          return false
        } else if (event.status === EVENT_STATUS_CANCELLED || moment(event.end_date).diff(moment()) < 0) {
          // Event ended or cancelled
          event.readonly = true
        }
        
        return true
      })
    },

    /**
     * Customize scheduler view
     */
    customizeSchedulerView: function () {
      scheduler.attachEvent("onTemplatesReady", function(){
        scheduler.templates.event_text=function(start, end, event){
          return formatString('<div class="event-name">%s</div>', event.name)
        }

        scheduler.templates.event_class = function(start, end, ev){
          var event_classes = []
          if (ev.status !== EVENT_STATUS_CANCELLED) {
            event_classes.push('event--' + ev.status)
          }
          
          if (moment(end).diff(moment()) < 0) {
            // event already ended
            event_classes.push('event--old')
          }
          
          if (ev.status === EVENT_STATUS_CANCELLED) {
            // event cancelled
            event_classes.push('event--cancelled')
          }
          
          return event_classes.join(' ')
        }
      })
    },

    /**
     * Get scheduler html
     * @returns {string}
     */
    getSchedulerHTML: function () {
      var schedulerHTML = '<div id="scheduler" class="dhx_cal_container" style=\'width:100%; height:100%\'>'+
        '      <div class="dhx_cal_navline">'+
        '        <div class="dhx_cal_prev_button"> </div>'+
        '        <div class="dhx_cal_next_button"> </div>'+
        '        <div class="dhx_cal_today_button"></div>'+
        '        <div class="dhx_cal_date"></div>'+
        '        <div class="dhx_cal_button button-create" style="right:200px;">CREATE</div>'+
        '        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>'+
        '        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>'+
        '        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>'+
        '      </div>'+
        '      <div class="dhx_cal_header"></div>'+
        '      <div class="dhx_cal_data"></div>'+
        '    </div>'
  
      return schedulerHTML
    }
  }


  /**
   * Format a string by pattern and inject parameters
   * @param {string} str
   * @returns {string}
   */
  function formatString (str) {
    var strParts = str.split(/%s/g).filter(function (value) { return value !== '' })
    var newParts = []
    if (strParts.length > 1) {
      for (var i = 0; i < strParts.length; i++) {
        newParts.push(strParts[i])
        newParts.push(arguments[i + 1] || '')
      }
    }
    return newParts.join('')
  }
  
  exports.Schedule = Schedule
})(window, jQuery, scheduler, moment)
