import React, { useState, useEffect } from 'react'

const menuItems = [
  {
    id: 1,
    name: 'Indomie Goreng Smoky',
    category: 'mie',
    price: 12000,
    image: 'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?auto=format&fit=crop&w=400&q=80',
    desc: 'Indomie goreng dengan aroma wajan smoky yang khas, telur, dan sayuran segar.'
  },
  {
    id: 2,
    name: 'Indomie Kuah Spesial',
    category: 'mie',
    price: 13000,
    image: 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=400&q=80',
    desc: 'Kuah gurih dengan bumbu spesial Warmindo, telur, dan topping lengkap.'
  },
  {
    id: 3,
    name: 'Mie Nyemek Pedas',
    category: 'mie',
    price: 14000,
    image: 'https://images.unsplash.com/photo-1585032226651-759b368d7246?auto=format&fit=crop&w=400&q=80',
    desc: 'Mie dengan kuah kental pedas, telur lava, dan aroma rempah autentik.'
  },
  {
    id: 4,
    name: 'Nasi Telor',
    category: 'nasi',
    price: 10000,
    image: 'https://images.unsplash.com/photo-1609501676725-7186f017a4b9?auto=format&fit=crop&w=400&q=80',
    desc: 'Nasi putih dengan telur mata sapi dan sambal pedas.'
  },
  {
    id: 5,
    name: 'Nasi Orek Tempe',
    category: 'nasi',
    price: 11000,
    image: 'https://images.unsplash.com/photo-1609501676725-7186f017a4b9?auto=format&fit=crop&w=400&q=80',
    desc: 'Nasi dengan tempe goreng renyah dan sambal kaya rasa.'
  },
  {
    id: 6,
    name: 'Telur Dadar',
    category: 'nasi',
    price: 9000,
    image: 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=400&q=80',
    desc: 'Telur dadar dengan nasi putih hangat.'
  },
  {
    id: 7,
    name: 'Kopi Susu',
    category: 'minuman',
    price: 8000,
    image: 'https://images.unsplash.com/photo-1559056199-641a0ac8b3f4?auto=format&fit=crop&w=400&q=80',
    desc: 'Kopi susu hangat nikmat menemani mie pedas.'
  },
  {
    id: 8,
    name: 'Es Teh Manis',
    category: 'minuman',
    price: 5000,
    image: 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=400&q=80',
    desc: 'Es teh segar dingin penyejuk tenggorokan.'
  },
  {
    id: 9,
    name: 'Jeruk Hangat',
    category: 'minuman',
    price: 6000,
    image: 'https://images.unsplash.com/photo-1613478223719-2ab802602423?auto=format&fit=crop&w=400&q=80',
    desc: 'Jeruk hangat manis menyegarkan.'
  }
]

export default function Menu({ onAddToCart }) {
  const [filter, setFilter] = useState('all')
  const [search, setSearch] = useState('')
  const [visibleItems, setVisibleItems] = useState({})

  useEffect(() => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          setVisibleItems(prev => ({
            ...prev,
            [entry.target.id]: true
          }))
        }
      })
    }, { threshold: 0.1 })

    document.querySelectorAll('.menu-card').forEach(el => {
      observer.observe(el)
    })

    return () => observer.disconnect()
  }, [filtered])

  const filtered = menuItems.filter(item => {
    const matchCategory = filter === 'all' || item.category === filter
    const matchSearch = item.name.toLowerCase().includes(search.toLowerCase()) ||
                       item.desc.toLowerCase().includes(search.toLowerCase())
    return matchCategory && matchSearch
  })

  return (
    <section id="menu" className="py-20 px-4 bg-gradient-to-b from-smoky-dark to-smoky-dark/95">
      <div className="max-w-7xl mx-auto">
        {/* Header */}
        <div className="text-center mb-12">
          <p className="text-smoky-fire text-xs font-bold uppercase tracking-widest animate-fade-in-up">📖 Katalog</p>
          <h2 className="font-display text-4xl md:text-5xl font-black text-white mt-2 animate-fade-in-up stagger-1">
            Menu Favorit Kami
          </h2>
          <p className="text-gray-400 text-sm mt-3 animate-fade-in-up stagger-2">Pilih menu favoritmu, pesan lewat tombol di setiap item!</p>
        </div>

        {/* Filter & Search */}
        <div className="flex flex-col sm:flex-row gap-4 mb-10 justify-center items-center animate-fade-in-up stagger-3">
          <div className="flex gap-2 flex-wrap justify-center">
            {['all', 'mie', 'nasi', 'minuman'].map(cat => (
              <button
                key={cat}
                onClick={() => setFilter(cat)}
                className={`px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300 ${
                  filter === cat
                    ? 'bg-gradient-to-r from-smoky-fire to-smoky-ember text-white shadow-lg shadow-smoky-fire/30 scale-105'
                    : 'bg-smoky-dark border border-smoky-fire/30 text-gray-300 hover:text-smoky-fire hover:border-smoky-fire/50 hover:scale-105'
                }`}
              >
                {cat === 'all' ? '🔥 Semua' : cat === 'mie' ? '🍜 Mie' : cat === 'nasi' ? '🍚 Nasi' : '🥤 Minuman'}
              </button>
            ))}
          </div>
          <input
            type="text"
            placeholder="Cari menu..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="px-4 py-2 bg-smoky-dark border border-smoky-fire/30 text-white rounded-lg text-sm focus:outline-none focus:border-smoky-fire focus:shadow-lg focus:shadow-smoky-fire/20 placeholder-gray-500 transition-all duration-300"
          />
        </div>

        {/* Menu Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {filtered.map((item, idx) => (
            <div 
              key={item.id} 
              id={`menu-${item.id}`}
              className={`menu-card relative bg-smoky-dark/60 border border-smoky-fire/20 rounded-xl overflow-hidden transition-all duration-300 card-hover group cursor-pointer ${
                visibleItems[`menu-${item.id}`] ? 'scroll-scale visible' : 'scroll-scale'
              }`}
              style={{ transitionDelay: visibleItems[`menu-${item.id}`] ? `${(idx % 3) * 0.1}s` : '0s' }}
            >
              <div className="relative h-48 overflow-hidden">
                <img
                  src={item.image}
                  alt={item.name}
                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                />
                {/* Image overlay glow */}
                <div className="absolute inset-0 bg-gradient-to-t from-smoky-dark/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                
                {/* Price badge with animation */}
                <div className="absolute bottom-3 right-3 bg-smoky-dark/90 backdrop-blur-md px-3 py-1 rounded-lg transform group-hover:scale-110 transition-all duration-300 shadow-lg shadow-smoky-fire/20">
                  <p className="text-smoky-cream font-bold text-sm">Rp {item.price.toLocaleString('id-ID')}</p>
                </div>
              </div>

              <div className="p-4">
                <h3 className="font-bold text-white mb-1 group-hover:text-smoky-fire transition-colors duration-300">
                  {item.name}
                </h3>
                <p className="text-gray-400 text-xs mb-4 line-clamp-2 group-hover:text-gray-300 transition-colors duration-300">
                  {item.desc}
                </p>
                <button
                  onClick={() => onAddToCart(item)}
                  className="w-full px-4 py-2 bg-gradient-to-r from-smoky-fire to-smoky-ember text-white rounded-lg font-semibold text-sm btn-premium transition-all duration-300 transform"
                >
                  ➕ Tambah Pesanan
                </button>
              </div>

              {/* Bottom accent line on hover */}
              <div className="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-smoky-fire/0 via-smoky-fire to-smoky-fire/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
            </div>
          ))}
        </div>

        {filtered.length === 0 && (
          <div className="text-center py-12 animate-fade-in-up">
            <p className="text-gray-400 text-sm">Tidak ada menu yang sesuai. Coba kata kunci lain!</p>
          </div>
        )}
      </div>
    </section>
  )
}
