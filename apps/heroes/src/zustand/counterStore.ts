import { StateCreator } from "zustand";

export interface CounterState {
  count: number;
  increment: () => void;
}

export const useCounterStore: StateCreator<CounterState> = (set) => ({
  count: 0,
  increment: () => set((state) => ({ count: state.count + 1 })),
});
