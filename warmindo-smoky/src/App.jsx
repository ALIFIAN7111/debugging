import React, { useState } from 'react'
import './index.css'
import Navbar from './components/Navbar'
import Hero from './components/Hero'
import Menu from './components/Menu'
import Features from './components/Features'
import Testimonials from './components/Testimonials'
import Location from './components/Location'
import Footer from './components/Footer'
import FloatingWhatsApp from './components/FloatingWhatsApp'
import Cart from './components/Cart'

function App() {
  const [cart, setCart] = useState([])
  const [showCart, setShowCart] = useState(false)

  const addToCart = (item) => {
    setCart([...cart, item])
  }

  const removeFromCart = (index) => {
    setCart(cart.filter((_, i) => i !== index))
  }

  const clearCart = () => {
    setCart([])
  }

  return (
    <div className="bg-smoky-dark min-h-screen">
      <Navbar cartCount={cart.length} onCartClick={() => setShowCart(!showCart)} />
      {showCart && (
        <Cart
          items={cart}
          onRemove={removeFromCart}
          onClear={clearCart}
          onClose={() => setShowCart(false)}
        />
      )}
      <Hero onOrderClick={() => setShowCart(true)} />
      <Menu onAddToCart={addToCart} />
      <Features />
      <Testimonials />
      <Location />
      <Footer />
      <FloatingWhatsApp cartCount={cart.length} />
    </div>
  )
}

export default App
