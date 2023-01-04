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

    const addSubscriber = async (name, email, state) => {
        await fetch('api/subscriber', {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ "name": name, "email": email, "state": state })
        });

        loadSubscribers()
    }

    return {
        loadSubscribers,
        deleteSubscriber,
        addSubscriber,
        subscribers
    }
}
