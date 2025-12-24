import React, { useState } from 'react';
import { supabase } from '@/lib/supabase';
import { X, Key, Loader2, CreditCard, CheckCircle } from 'lucide-react';
import { CTFEvent } from '@/types/ctf';

interface RedeemCodeModalProps {
  isOpen: boolean;
  onClose: () => void;
  event: CTFEvent;
  onSuccess: () => void;
}

const RedeemCodeModal: React.FC<RedeemCodeModalProps> = ({ isOpen, onClose, event, onSuccess }) => {
  const [code, setCode] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState(false);
  const [activeTab, setActiveTab] = useState<'code' | 'payment'>('code');

  if (!isOpen) return null;

  const handleRedeemCode = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      const { data, error } = await supabase.functions.invoke('redeem-code', {
        body: { code: code.trim().toUpperCase() }
      });

      if (error) throw error;

      if (data.success) {
        setSuccess(true);
        setTimeout(() => {
          onSuccess();
          onClose();
        }, 1500);
      } else {
        setError(data.message || 'Invalid code');
      }
    } catch (err: any) {
      setError(err.message || 'Failed to redeem code');
    } finally {
      setLoading(false);
    }
  };

  const formatCode = (value: string) => {
    const cleaned = value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
    const parts = [];
    for (let i = 0; i < cleaned.length && i < 16; i += 4) {
      parts.push(cleaned.slice(i, i + 4));
    }
    return parts.join('-');
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center">
      <div className="absolute inset-0 bg-black/80 backdrop-blur-sm" onClick={onClose} />
      <div className="relative bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/30 rounded-lg p-8 w-full max-w-lg shadow-2xl shadow-[#00ff41]/10">
        <button
          onClick={onClose}
          className="absolute top-4 right-4 text-gray-400 hover:text-[#00ff41] transition-colors"
        >
          <X size={24} />
        </button>

        {success ? (
          <div className="text-center py-8">
            <CheckCircle className="text-[#00ff41] mx-auto mb-4" size={64} />
            <h3 className="text-2xl font-mono font-bold text-[#00ff41] mb-2">ACCESS_GRANTED</h3>
            <p className="text-gray-400 font-mono">Redirecting to event...</p>
          </div>
        ) : (
          <>
            <h2 className="text-2xl font-mono font-bold text-white mb-2">
              UNLOCK_EVENT
            </h2>
            <p className="text-gray-400 font-mono text-sm mb-6">
              {event.name} - ${event.price}
            </p>

            <div className="flex gap-2 mb-6">
              <button
                onClick={() => setActiveTab('code')}
                className={`flex-1 py-2 px-4 rounded font-mono text-sm transition-all flex items-center justify-center gap-2 ${
                  activeTab === 'code'
                    ? 'bg-[#00ff41] text-black'
                    : 'bg-black/30 text-gray-400 hover:text-white border border-[#00ff41]/30'
                }`}
              >
                <Key size={16} />
                ACCESS_CODE
              </button>
              <button
                onClick={() => setActiveTab('payment')}
                className={`flex-1 py-2 px-4 rounded font-mono text-sm transition-all flex items-center justify-center gap-2 ${
                  activeTab === 'payment'
                    ? 'bg-[#00ff41] text-black'
                    : 'bg-black/30 text-gray-400 hover:text-white border border-[#00ff41]/30'
                }`}
              >
                <CreditCard size={16} />
                PAY_NOW
              </button>
            </div>

            {activeTab === 'code' ? (
              <form onSubmit={handleRedeemCode} className="space-y-4">
                <div>
                  <label className="block text-[#00ff41] font-mono text-sm mb-2">
                    ENTER_ACCESS_CODE
                  </label>
                  <input
                    type="text"
                    value={code}
                    onChange={(e) => setCode(formatCode(e.target.value))}
                    className="w-full bg-black/50 border border-[#00ff41]/30 rounded px-4 py-4 text-white font-mono text-xl tracking-widest text-center focus:border-[#00ff41] focus:outline-none focus:ring-1 focus:ring-[#00ff41]/50 transition-all uppercase"
                    placeholder="XXXX-XXXX-XXXX-XXXX"
                    maxLength={19}
                  />
                  <p className="text-gray-500 font-mono text-xs mt-2">
                    Enter the 16-character access code provided to you
                  </p>
                </div>

                {error && (
                  <div className="bg-red-500/10 border border-red-500/30 rounded p-3 text-red-400 text-sm font-mono">
                    ERROR: {error}
                  </div>
                )}

                <button
                  type="submit"
                  disabled={loading || code.replace(/-/g, '').length !== 16}
                  className="w-full bg-[#00ff41] text-black font-mono font-bold py-3 rounded hover:bg-[#00ff41]/80 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                  {loading ? (
                    <>
                      <Loader2 className="animate-spin" size={20} />
                      VERIFYING...
                    </>
                  ) : (
                    <>
                      <Key size={20} />
                      REDEEM_CODE
                    </>
                  )}
                </button>
              </form>
            ) : (
              <div className="space-y-4">
                <div className="bg-black/30 border border-[#00ff41]/20 rounded-lg p-6">
                  <div className="flex justify-between items-center mb-4">
                    <span className="text-gray-400 font-mono">Event Access</span>
                    <span className="text-white font-mono font-bold">${event.price}</span>
                  </div>
                  <div className="border-t border-[#00ff41]/20 pt-4 flex justify-between items-center">
                    <span className="text-[#00ff41] font-mono font-bold">TOTAL</span>
                    <span className="text-[#00ff41] font-mono font-bold text-xl">${event.price}</span>
                  </div>
                </div>

                <button
                  className="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-mono font-bold py-3 rounded hover:opacity-90 transition-all flex items-center justify-center gap-2"
                >
                  <CreditCard size={20} />
                  PAY_WITH_STRIPE
                </button>

                <button
                  className="w-full bg-[#00C853] text-white font-mono font-bold py-3 rounded hover:opacity-90 transition-all flex items-center justify-center gap-2"
                >
                  <CreditCard size={20} />
                  PAY_WITH_PAYSTACK
                </button>

                <p className="text-gray-500 font-mono text-xs text-center">
                  Payment integration placeholder - Connect your payment provider
                </p>
              </div>
            )}
          </>
        )}
      </div>
    </div>
  );
};

export default RedeemCodeModal;
