import React from 'react'

export default function Cart({ items, onRemove, onClear, onClose }) {
  const total = items.reduce((sum, item) => sum + item.price, 0)

  const handleWhatsAppOrder = () => {
    if (items.length === 0) {
      alert('Keranjang kosong! Pilih menu dulu.')
      return
    }

    const itemList = items
      .map((item, i) => `${i + 1}. ${item.name} - Rp ${item.price.toLocaleString('id-ID')}`)
      .join('%0A')

    const message = `Halo Warmindo Smoky, saya ingin pesan:%0A%0A${itemList}%0A%0A*Total: Rp ${total.toLocaleString('id-ID')}*%0A%0ATerima kasih!`

    window.open(`https://wa.me/085752376632?text=${message}`, '_blank')
    onClear()
    onClose()
  }

  return (
    <div className="fixed inset-0 bg-black/50 z-40 p-4 overflow-y-auto">
      <div className="max-w-2xl mx-auto mt-8 bg-smoky-dark border-2 border-smoky-fire/30 rounded-xl p-6">
        <div className="flex items-center justify-between mb-6">
          <h2 className="font-display text-2xl font-black text-white">🛒 Keranjang Pesanan</h2>
          <button
            onClick={onClose}
            className="text-gray-400 hover:text-white text-2xl"
          >
            ✕
          </button>
        </div>

        {items.length === 0 ? (
          <div className="text-center py-12">
            <p className="text-gray-400 text-sm">Keranjang kosong. Pilih menu dulu!</p>
            <button
              onClick={onClose}
              className="mt-4 px-6 py-2 bg-gradient-to-r from-smoky-fire to-smoky-ember text-white rounded-lg font-semibold text-sm hover:shadow-lg hover:shadow-smoky-fire/50 transition"
            >
              ← Kembali ke Menu
            </button>
          </div>
        ) : (
          <>
            <div className="space-y-3 mb-6 max-h-72 overflow-y-auto">
              {items.map((item, i) => (
                <div key={i} className="flex items-center justify-between p-3 bg-smoky-dark/60 border border-smoky-fire/20 rounded-lg">
                  <div className="flex-1">
                    <p className="font-semibold text-white text-sm">{item.name}</p>
                    <p className="text-smoky-fire text-xs">Rp {item.price.toLocaleString('id-ID')}</p>
                  </div>
                  <button
                    onClick={() => onRemove(i)}
                    className="ml-4 px-3 py-1 bg-smoky-ember/20 text-smoky-ember hover:bg-smoky-ember/40 rounded-lg text-xs font-bold transition"
                  >
                    Hapus
                  </button>
                </div>
              ))}
            </div>

            <div className="border-t border-smoky-fire/20 pt-4 mb-6">
              <div className="flex items-center justify-between mb-4">
                <span className="text-gray-300 font-semibold">Total ({items.length} item):</span>
                <span className="font-display text-2xl font-black text-smoky-cream">
                  Rp {total.toLocaleString('id-ID')}
                </span>
              </div>
            </div>

            <div className="flex gap-3">
              <button
                onClick={onClear}
                className="flex-1 px-4 py-2 border-2 border-smoky-fire/30 text-gray-300 rounded-lg font-semibold hover:border-smoky-fire/50 transition text-sm"
              >
                Kosongkan Keranjang
              </button>
              <button
                onClick={handleWhatsAppOrder}
                className="flex-1 px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg font-semibold hover:shadow-lg hover:shadow-emerald-500/50 transition text-sm flex items-center justify-center gap-2"
              >
                💬 Pesan via WhatsApp
              </button>
            </div>
          </>
        )}
      </div>
    </div>
  )
}
