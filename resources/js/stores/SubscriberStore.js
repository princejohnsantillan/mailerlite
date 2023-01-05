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

    const updateSubscriber = async (subscriber) => {
        await fetch(`api/subscriber/${subscriber.id}`, {
            method: "PATCH",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ "name": subscriber.name, "email": subscriber.email, "state": subscriber.state })
        });

        loadSubscribers()
    }

    const saveSubscriberFields = async (subscriber, fields) => {
        await fetch(`api/subscriber/${subscriber}`, {
            method: "PATCH",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ "fields": fields })
        });

        loadSubscribers()
    }

    return {
        loadSubscribers,
        deleteSubscriber,
        addSubscriber,
        updateSubscriber,
        saveSubscriberFields,
        subscribers
    }
}
