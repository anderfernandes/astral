<script>
function fetchEvents(calEvent, jsEvent, view) {
  fetch(`/api/event/${calEvent.id}`)
    .then(response => response.json())
    .then(response => {

      document.querySelector('#details').innerHTML = null

      var memos = ''

      if (response.memos.length > 0) {
        response.memos.forEach(function (memo)
        {
          memos +=
          `
          <div class="comment">
            <div class="avatar"><i class="user circle big icon"></i></div>
            <div class="content">
              <div class="author">
                ${memo.author.id == 1 ? "System" : memo.author.name}
                <div class="ui tiny black label">${memo.author.id == 1 ? "System" : memo.author.role}</div>
                <div class="metadata">
                  <span class="date">${moment(memo.created_at).calendar()}</span>
                </div>
              </div>
              <div class="text">
                ${memo.message}
              </div>
            </div>
          </div>
          `
        }
      )
    } else {
      memos =
      `
      <div class="ui info icon message">
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">
            No Memos
          </div>
          <p>No one has left a memo for this event yet.</p>
        </div>
      </div>
      `
    }

      var dateFormat = response.allDay ? 'dddd, MMMM D, YYYY' : 'dddd, MMMM D, YYYY [at] h:mm A'

      function getDescription() {

        var description =
        `
        {{-- Show Description --}}
        <h4 class="ui horizontal divider header">
          <i class="film icon"></i> Show Description
        </h4>
        ${ marked(response.show.description) }
        <br><br>
        Duration: ${response.show.duration} minutes
        `

        response.allDay ? description = `` : description = description

        return description
      }

      // Start this variable with a message box saying that there are no sales for this event
      var sales = ''

      if (response.sales.length > 0) {
        response.sales.forEach(function (sale)
        {
          var tickets = ``
          sale.tickets.forEach(function (ticket) {
            tickets +=
            `
            <div class="ui black label" style="margin-left:0">
            <i class="ticket icon"></i>
            ${ticket.quantity} <div class="detail">${ticket.type}</div>
            </div>
            `
          })

          var products = ``
          sale.products.forEach(function (product) {
            products +=
            `
            <div class="ui black label" style="margin-left:0">
              <i class="box icon"></i>
              ${product.quantity} <div class="detail">${product.name}</div>
            </div>
            `
          })

          {{-- This function gets the sale status and returns it prettified in the modal --}}
          function getSaleStatus(status) {
            switch(status) {
              case 'complete'  : return `<div class="ui green label"><i class="checkmark icon"></i>${status}</div>`
              case 'no show'   : return `<div class="ui orange label"><i class="thumbs outline down icon"></i>${status}</div>`
              case 'open'      : return `<div class="ui violet label"><i class="unlock icon"></i>${status}</div>`
              case 'tentative' : return `<div class="ui yellow label"><i class="help icon"></i>${status}</div>`
              case 'canceled'  : return `<div class="ui red label"><i class="remove icon"></i>${status}</div>`
              case 'confirmed'  : return `<div class="ui basic green label"><i class="thumbs up icon"></i>${status}</div>`
            }
          }

          sales +=
          `
          <div class="ui ${sale.status == 'canceled' ? `red raised` : `raised`} card">
            <div class="content">
              <div class="header">
                <a href="/admin/sales#/${sale.id}" target="_blank" style="padding: 0 0 0 0">Sale # ${sale.id}</a>
                <div class="right floated">
                  <div class="ui black tag label"><i class="dollar icon"></i> ${parseFloat(sale.total).toFixed(2)}</div>
                  ${getSaleStatus(sale.status)}
                </div>
              </div>
              <div class="meta" target="_blank">
                <i class="user circle icon"></i> ${sale.creator.id == 1 ? "System" : sale.creator.name}
              </div>
              <div class="meta">
                <i class="pencil icon"></i> ${moment(sale.created_at).format('dddd, MMMM D, YYYY [at] h:mm:ss A')} (${moment(sale.created_at).fromNow()})
              </div>
                ${sale.organization.name == sale.customer.name ? `` : `<a class="meta" href="/admin/users/${sale.customer.id}" target="_blank"><i class="user icon"></i> ${sale.customer.name}</a>`}
                ${sale.organization.id == 1 ? `` : ` | <a class="meta" href="/admin/organizations/${sale.organization.id}" target="_blank"><i class="university icon"></i> ${sale.organization.name}</a>` }
                <br><br>
              <div class="description">${tickets} ${products}</div>
            </div>
          </div>
          `
        }
      )
      } else {
        sales =
        `
        <div class="ui info icon message">
          <i class="info circle icon"></i>
          <div class="content">
            <div class="header">
              No Group Sales!
            </div>
            <p>There are no group sales for this show.</p>
          </div>
        </div>
        `
      }

      var header =
      `
      <i class="close icon"></i>
      <div class="ui header">
        <i class="calendar alternate icon"></i>
        <div class="content">
          Event #${response.id}
        </div>
      </div>
      `
      var body = `
      <div class="scrolling content">
        <div class="ui items">
          <div class="ui item">
            ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui medium rounded image"><img src="${response.show.cover}"></div>`}
            <div class="content">
              <div class="meta">
                <div class="ui label" style="background-color: ${response.color}; color: rgba(255, 255, 255, 0.8)"><i class="calendar alternate icon"></i> <div class="detail">${response.type}</div></div>
                  ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui black label"><i class="clock outline icon"></i><div class="detail">${response.show.duration} minutes</div></div>`}
                  ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui black label"><i class="ticket icon"></i><div class="detail">${response.tickets_sold} tickets sold</div></div>`}
                  <div class="ui black label"><i class="${response.public ? `users` : `user`} icon"></i><div class="detail">${response.public ? `Public` : `Private`}</div></div>
                </div>
                <div class="ui large header">
                  ${ (response.allDay || response.show.id == 1) ? response.memo : response.show.name}
                  <div class="sub header">
                    <i class="calendar alternate icon"></i>${moment(response.start).format(dateFormat)}
                    (${moment(response.start).fromNow()})
                    </div>
                </div>
                <div class="extra">
                  <p>
                    <i class="user circle icon"></i> ${response.creator.id == 1 ? "System" : response.creator.name} |
                    <i class="pencil icon"></i> ${moment(response.created_at).format(dateFormat)} (${moment(response.created_at).fromNow()}) |
                    <i class="edit icon"></i> ${moment(response.updated_at).format(dateFormat)} (${moment(response.updated_at).fromNow()})
                  </p>
                </div>
                <div class="description">
                  {{-- Sales --}}
                  ${ (response.allDay || response.show.id == 1) ? `` :
                    `
                    <h4 class="ui horizontal divider header">
                      <i class="dollar icon"></i> Sales
                    </h4>
                    <div class="ui two doubling stackable cards">
                      ${sales}
                    </div>
                    `
                  }
                  {{-- Memos --}}
                  <h4 class="ui horizontal divider header">
                    <i class="comment alternate outline icon"></i> Memos
                  </h4>
                  ${response.memos.length > 0 ? `<div class="ui comments">${memos}</div>` : memos}
                  ${getDescription()}
                </div>
            </div>
          </div>
        </div>
      </div>
      `
      var deleteButton = ''

      if (response.tickets_sold == 0) {
        deleteButton =
        `
        <form action="/admin/events/${response.id}" method="POST" style="display:contents">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button class="ui red right labeled icon button" type="submit">
            Delete
            <i class="trash icon"></i>
          </button>
        </form>
        `
      }

      var footer = `
      <div class="actions">
        ${deleteButton}
        <a href="/admin/events/${response.id}/edit" class="ui yellow right labeled icon button">
          Edit
          <i class="edit icon"></i>
        </a>
        <div class="ui black deny button">
          Close
        </div>
      </div>
      </div>
      `

    document.querySelector('#details').innerHTML = header + body + footer
    $('#details').modal('show')
  });
}
</script>
