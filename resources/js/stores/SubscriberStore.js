import { ref } from "vue"

const subscribers = ref([])

export function useSubscriberStore() {
    const loadSubscribers = async () => {
        const response = await fetch("/api/subscriber")
        const body = await response.json()

        subscribers.value = body.data
    }

    const deleteSubscriber = async (id) => {
        await fetch(`/api/subscriber/${id}`, { method: "DELETE" })

        loadSubscribers()
    }

    return {
        loadSubscribers,
        deleteSubscriber,
        subscribers
    }
}
