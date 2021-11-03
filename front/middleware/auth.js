export default function ({ redirect, store }) {
  const isAuthenticated = !!store.state.auth.token
  if (!isAuthenticated) {
    redirect({ name: 'index' })
  }
}
