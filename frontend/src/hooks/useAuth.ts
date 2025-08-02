import { create } from 'zustand'
import { persist } from 'zustand/middleware'
import { jwtDecode } from 'jwt-decode'
import api from '../services/api'

// ✅ Typage du payload JWT
interface DecodedUser {
  email: string
  roles: string[]
  exp: number
  iat: number
}

// ✅ Typage du state Zustand
interface AuthState {
  token: string | null
  user: DecodedUser | null
  login: (email: string, password: string) => Promise<void>
  logout: () => void
  isAuthenticated: () => boolean
}

export const useAuth = create<AuthState>()(
  persist(
    (set, get) => ({
      token: null,
      user: null,

      login: async (email, password) => {
        const res = await api.post('/login', { email, password })
        const token = res.data.token
        const user = jwtDecode<DecodedUser>(token)
        set({ token, user })
      },

      logout: () => {
        set({ token: null, user: null })
      },

      isAuthenticated: () => {
        return !!get().token
      },
    }),
    {
      name: 'auth', // Clé utilisée dans localStorage
    }
  )
)
