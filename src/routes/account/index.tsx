import { createFileRoute } from '@tanstack/solid-router'

export const Route = createFileRoute('/account/')({
  component: RouteComponent,
})

function RouteComponent() {
  return <div>Hello "/(account)/account/"!</div>
}
