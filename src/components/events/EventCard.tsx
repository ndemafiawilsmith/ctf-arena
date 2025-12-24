import React from 'react';
import { CTFEvent } from '@/types/ctf';
import { Calendar, Users, Lock, Unlock, Clock, DollarSign } from 'lucide-react';

interface EventCardProps {
  event: CTFEvent;
  hasAccess: boolean;
  onJoin: () => void;
}

const EventCard: React.FC<EventCardProps> = ({ event, hasAccess, onJoin }) => {
  const now = new Date();
  const startTime = new Date(event.start_time);
  const endTime = new Date(event.end_time);
  
  const isLive = now >= startTime && now <= endTime;
  const isUpcoming = now < startTime;
  const isEnded = now > endTime;

  const getTimeRemaining = () => {
    const diff = startTime.getTime() - now.getTime();
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    if (days > 0) return `${days}d ${hours}h`;
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    return `${hours}h ${minutes}m`;
  };

  const getStatus = () => {
    if (isLive) return { text: 'LIVE', color: 'bg-[#00ff41]', textColor: 'text-black' };
    if (isUpcoming) return { text: 'UPCOMING', color: 'bg-yellow-500', textColor: 'text-black' };
    return { text: 'ENDED', color: 'bg-gray-600', textColor: 'text-white' };
  };

  const status = getStatus();

  return (
    <div className="group relative bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg overflow-hidden hover:border-[#00ff41]/50 transition-all duration-300 hover:shadow-lg hover:shadow-[#00ff41]/10">
      <div className="relative h-48 overflow-hidden">
        <img
          src={event.cover_image_url}
          alt={event.name}
          className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-[#0d0015] via-transparent to-transparent" />
        
        {/* Status Badge */}
        <div className={`absolute top-3 left-3 px-3 py-1 rounded ${status.color} ${status.textColor} font-mono text-xs font-bold flex items-center gap-1`}>
          {isLive && <span className="w-2 h-2 bg-black rounded-full animate-pulse" />}
          {status.text}
        </div>

        {/* Price Badge */}
        {event.is_paid ? (
          <div className="absolute top-3 right-3 px-3 py-1 rounded bg-purple-600 text-white font-mono text-xs font-bold flex items-center gap-1">
            <DollarSign size={12} />
            {event.price}
          </div>
        ) : (
          <div className="absolute top-3 right-3 px-3 py-1 rounded bg-[#00ff41]/20 text-[#00ff41] font-mono text-xs font-bold">
            FREE
          </div>
        )}
      </div>

      <div className="p-5">
        <h3 className="text-xl font-mono font-bold text-white mb-2 group-hover:text-[#00ff41] transition-colors">
          {event.name}
        </h3>
        <p className="text-gray-400 text-sm mb-4 line-clamp-2">
          {event.description}
        </p>

        <div className="flex flex-wrap gap-3 mb-4 text-xs font-mono text-gray-500">
          <div className="flex items-center gap-1">
            <Calendar size={14} />
            {startTime.toLocaleDateString()}
          </div>
          {isUpcoming && (
            <div className="flex items-center gap-1 text-yellow-500">
              <Clock size={14} />
              Starts in {getTimeRemaining()}
            </div>
          )}
          {event.max_participants && (
            <div className="flex items-center gap-1">
              <Users size={14} />
              {event.max_participants} spots
            </div>
          )}
        </div>

        <button
          onClick={onJoin}
          disabled={isEnded}
          className={`w-full py-3 rounded font-mono font-bold text-sm transition-all flex items-center justify-center gap-2 ${
            isEnded
              ? 'bg-gray-700 text-gray-400 cursor-not-allowed'
              : hasAccess || !event.is_paid
              ? 'bg-[#00ff41] text-black hover:bg-[#00ff41]/80'
              : 'bg-purple-600 text-white hover:bg-purple-700'
          }`}
        >
          {isEnded ? (
            'EVENT_ENDED'
          ) : hasAccess || !event.is_paid ? (
            <>
              <Unlock size={16} />
              ENTER_EVENT
            </>
          ) : (
            <>
              <Lock size={16} />
              UNLOCK_ACCESS
            </>
          )}
        </button>
      </div>
    </div>
  );
};

export default EventCard;
